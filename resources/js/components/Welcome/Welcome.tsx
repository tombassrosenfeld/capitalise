import { IWelcomePropTypes } from './Welcome.types';
import React, { FC } from 'react';
import { Button } from '@mui/material';

export const Welcome: FC<IWelcomePropTypes> = ({ fetchQuizData, loading }) => (
    <>
        <p>Welcome to Capitalise. Shall we get started?</p>
        <Button
            variant="contained"
            color="primary"
            onClick={fetchQuizData}
            loading={loading}
        >Let's go!</Button>
    </>
);
