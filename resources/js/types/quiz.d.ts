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
