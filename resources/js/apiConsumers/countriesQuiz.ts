import axios from 'axios';
import { IQuizData, IQuizResult } from '@/types/quiz';

interface IQuizDataResponse {
    data: IQuizData | null;
    errors: boolean;
}

interface IQuizResultResponse {
    data: IQuizResult | null;
    errors: boolean;
}

export const getQuizDataRequest = async (): Promise<IQuizDataResponse> => {
    try {
        const response = await axios.get('http://localhost/api/capital-quiz');
        return { data: response.data, errors: false };
    } catch {
        return { data: null, errors: true };
    }
};

export const postQuizAnswer = async ({ country, capital }: IQuizAnswer): Promise<IQuizResultResponse> => {
    try {
        const response = await axios.post(
            'http://localhost/api/capital-quiz/answer',
            {
                country,
                capital
            }
        );

        return { data: response.data, errors: false };
    } catch {
        return { data: null, errors: true };
    }
};
