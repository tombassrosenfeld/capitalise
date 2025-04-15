import { IWelcomePropTypes } from './Welcome.types';
import React, { FC } from 'react';
import { Button, Typography } from '@mui/material';

export const Welcome: FC<IWelcomePropTypes> = ({ fetchQuizData, loading }) => (
    <>
        <Typography marginBottom="0.5rem" component="p">Welcome to Capitalise. Shall we get started?</Typography>
        <Button
            variant="contained"
            color="primary"
            onClick={fetchQuizData}
            loading={loading}
        >Let's go!</Button>
    </>
);
