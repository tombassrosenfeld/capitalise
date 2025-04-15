import axios from 'axios';

type TCountry = string;
export type TCity = string;

export interface IQuizData {
    country: TCountry;
    cities: TCity[];
}

export interface IQuizAnswer {
    country: TCountry;
    capital: TCity;
}

export interface IQuizResult extends IQuizAnswer {
    correct: boolean;
}

export const getQuizDataRequest = async (): Promise<IQuizData> => {
    const response = await axios.get('http://localhost/api/capital-quiz');

    return response.data;
};

export const postQuizAnswer = async ({ country, capital }: IQuizAnswer): Promise<IQuizResult>  => {
    const response = await axios.post(
        'http://localhost/api/capital-quiz/answer',
        {
            country,
            capital
        }
    );

    return response.data;
};
