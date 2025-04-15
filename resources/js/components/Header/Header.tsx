import styles from './Header.module.css';
import { FC } from 'react';
import { Typography } from '@mui/material';

export const Header: FC = () => (
    <header className={styles.header}>
        <Typography variant="h3" component="h1" className={styles.heading}>
            Capitalise
        </Typography>
    </header>
)
