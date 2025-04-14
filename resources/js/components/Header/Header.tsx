import styles from '@/pages/Home/Home.module.css';
import { FC } from 'react';

export const Header: FC = () => (
    <header className={styles.header}>
        <h1 className={styles.heading}>Capitalise</h1>
    </header>
)
