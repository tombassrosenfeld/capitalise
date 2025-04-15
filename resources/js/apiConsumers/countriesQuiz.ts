import axios from 'axios';

export interface IQuizData {
    country: string;
    cities: string[];
}

export const getQuizDataRequest = async () => {
    const response = await axios.get('http://localhost/api/capital-quiz');

    console.log(response);
    return response.data
};
