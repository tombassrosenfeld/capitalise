import React, { FC, useState } from 'react';
import { Header } from '@/components/Header/Header';

import styles from './Home.module.css';
import { getQuizDataRequest, IQuizData, IQuizResult, postQuizAnswer } from '@/apiConsumers/countriesQuiz';
import { Welcome } from '@/components/Welcome/Welcome';
import { Quiz } from '@/components/Quiz/Quiz';
import { Typography } from '@mui/material';

export const Home: FC = () => {
    const [quizData, setQuizData] = useState<IQuizData | null>(null);
    const [loading, setLoading] = useState(false);
    const [selectedCapital, setSelectedCapital] = useState<string | null>(null);
    const [result, setResult] = useState<IQuizResult | null>(null);
    const [streakCount, setStreakCount] = useState<number>(0);
    const { country } = quizData ?? {};
    const [apiError, setApiError] = useState(false);

    const handleFetchQuizData = async () => {
        setLoading(true);

        const { data: newQuizData, errors } = await getQuizDataRequest();

        setApiError(errors);
        setQuizData(newQuizData ?? null);
        setSelectedCapital(null);
        setResult(null);
        setLoading(false);
    };

    const handleSubmitAnswer = async () => {
        setLoading(true);
        if (country && selectedCapital) {
            const { data: result, errors } = await postQuizAnswer({ country, capital: selectedCapital });

            setStreakCount((currentCount) => result?.correct ? currentCount + 1 : 0);
            setResult(result);
            setApiError(errors);
        }
        setLoading(false);
    };

    return (
        <>
            <Header />
            <main className={styles.content}>
                {
                    !quizData && (
                        <Welcome
                            fetchQuizData={handleFetchQuizData}
                            loading={loading}
                        />
                    )
                }
                {
                    quizData && (
                        <>
                            <Quiz
                                quizData={quizData}
                                selectedCapital={selectedCapital}
                                setSelectedCapital={setSelectedCapital}
                                submitAnswer={handleSubmitAnswer}
                                fetchQuiz={handleFetchQuizData}
                                loading={loading}
                                result={result}
                            />
                            <Typography className={styles.streakCount} component="p">Current streak: {streakCount}</Typography>
                        </>
                    )
                }
                <div aria-live="assertive" className={styles.errorContainer}>
                    <Typography variant="body1" component="p">
                        {
                            apiError && (
                                "We're having a bit of trouble with our server. Please try again."
                            )
                        }
                    </Typography>
                </div>
            </main>
        </>
    );
};
