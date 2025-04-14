import styles from './Home.module.css';
import { FC } from 'react';
import { Header } from '@/components/Header/Header';

export const Home: FC = () => {
    return (
        <>
            <Header />
            <main className={styles.content}>

            </main>
        </>
    );
};
