import { Dispatch, type SetStateAction } from 'react';
import { IQuizData, IQuizResult, TCity } from '@/types/quiz';

export interface IQuizPropTypes {
    quizData: IQuizData;
    selectedCapital: TCity | null;
    result: IQuizResult | null;
    submitAnswer: () => void;
    fetchQuiz: () => void;
    setSelectedCapital: Dispatch<SetStateAction<string|null>>;
    loading: boolean;
}
