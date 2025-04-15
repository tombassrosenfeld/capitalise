import { type IQuizData, IQuizResult, type TCity } from '@/apiConsumers/countriesQuiz';
import { Dispatch, type SetStateAction } from 'react';

export interface IQuizPropTypes {
    quizData: IQuizData;
    selectedCapital: TCity | null;
    result: IQuizResult | null;
    submitAnswer: () => void;
    fetchQuiz: () => void;
    setSelectedCapital: Dispatch<SetStateAction<string|null>>;
    loading: boolean;
}
