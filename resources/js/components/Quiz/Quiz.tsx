import React, { type FC, useMemo } from 'react';
import { type IQuizPropTypes } from '@/components/Quiz/Quiz.types';
import { Button, FormControlLabel, Radio, RadioGroup, Typography } from '@mui/material';

import styles from './Quiz.module.css';
import { type TCity } from '@/types/quiz';

export const Quiz: FC<IQuizPropTypes> = (
    {
        quizData,
        selectedCapital,
        setSelectedCapital,
        result,
        submitAnswer,
        fetchQuiz,
        loading
    }
) => {
    const { country, cities } = quizData ?? {};

    const { capital: correctCity, correct } = result ?? {};

    const resultMessage = useMemo(
        // if we have no result then leave the messages blank
        () => result
            ? (
                correct
                    ? 'Yes! Nice work.'
                    : `Not this time. The capital of ${country} is ${correctCity}. Let's try again!`
            )
            : null,
        [correct, correctCity, country, result]
    );

    return (
        <>
            <Typography component="p">What city is the capital of {country}?</Typography>
            <RadioGroup
                aria-required={true}
                className={styles.radioGroup}
                onChange={(_, value) => setSelectedCapital(value)}
            >
                {
                    cities && cities.map((city: TCity, index: number) => (
                        <FormControlLabel
                            // This key composition catches the case that we end up with multiple
                            // empty cities and prevents key duplication.
                            // Not ideal and if this happens frequently, a backend solution will be needed
                            key={`${city}-${index}`}
                            value={city}
                            control={<Radio className={styles.radio} />}
                            label={city}
                            disabled={!!result}
                        />
                    ))
                }
            </RadioGroup>
            <div
                className={styles.messageWrapper}
                aria-live="assertive"
            >
                <Typography component="p">{resultMessage}</Typography>
            </div>
            {/* switch out the buttons based on the lifecycle of the quiz - we don't want to submit again.*/}
            {result ? (
                <Button
                    type="button"
                    variant="contained"
                    color="primary"
                    onClick={fetchQuiz}
                    loading={loading}
                >Next Question</Button>
            ) : (
                <Button
                    type="button"
                    variant="contained"
                    color="primary"
                    onClick={submitAnswer}
                    disabled={!selectedCapital}
                    loading={loading}
                >Submit</Button>
            )}
        </>
    );
};
