import React, { FC, useState } from 'react';
import { Header } from '@/components/Header/Header';

import styles from './Home.module.css';
import { getQuizDataRequest, IQuizData, IQuizResult, postQuizAnswer } from '@/apiConsumers/countriesQuiz';
import { Welcome } from '@/components/Welcome/Welcome';
import { Quiz } from '@/components/Quiz/Quiz';

export const Home: FC = () => {

    const [quizData, setQuizData] = useState<IQuizData | null>(null);
    const [loading, setLoading] = useState(false);
    const [selectedCapital, setSelectedCapital] = useState<string | null>(null);
    const [result, setResult] = useState<IQuizResult | null>(null);

    const { country } = quizData ?? {};

    const handleFetchQuizData = async () => {
        setLoading(true);
        setSelectedCapital(null)
        const newQuizData = await getQuizDataRequest();

        setQuizData(newQuizData ?? null);
        setResult(null);
        setLoading(false);
    };

    const handleSubmitAnswer = async () => {
        setLoading(true);
        if (country && selectedCapital) {
            const result = await postQuizAnswer({ country, capital: selectedCapital });
            setResult(result);
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
                        <Quiz
                            quizData={quizData}
                            selectedCapital={selectedCapital}
                            setSelectedCapital={setSelectedCapital}
                            submitAnswer={handleSubmitAnswer}
                            fetchQuiz={handleFetchQuizData}
                            loading={loading}
                            result={result}
                        />
                    )
                }
            </main>
        </>
    );
};
