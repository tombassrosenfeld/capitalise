# Capialise

Welcome to capitalise. 

## Setup

Clone this repo, navigate to the root of the project and run `npm install && npm run build`. 

This project uses Laravel sail so run `php artisan sail:install` and `./vendor/bin/sail up -d` (see the alias below if you'd like to be able to use `sail`). 
Run `sail npm run dev` and the app will be served at `localhost`.

Optionally, if you don't have an alias for sail, you can add the following to your aliases:
`alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'`

## Architectural decisions

I initially considered using a facade and/or interfaces for the CapitalCitiesData service. 
This would enable swapping it out the service used should a better alternative present itself. 
However, this felt like overkill for a project this simple at this stage of development.

I opted to call for the countries data every time it's used rather than using a countries table  and a related model. 
This is largely because I felt that this data represents third party data that _could_ change, even if it's not likely. 
Additionally in production, with caching, these requests should be captured and we would likely use the cached response. 

## Out of scope goals

I would like to implement a history that would prevent the user being presented with the same country within a reasonable timeframe. 
This could either be implemented on the front end and be confined to the current session, or we could use authenticated users and keep a record of each user's history. 
I would also use this to record streak data and keep track of the user's high score. 

In lieu of persistence of the user's history, I would use session storage to keep a track of their current streak and longest streak by creating a useSessionStorage hook.

## Omissions

I have failed to write front end tests but feel that I have run out of time for this. 
I would have liked to have component unit test coverage and would have used Jest (or vitest as I'm using vite).

I also spotted that the api service has an endpoint for the retrieval of a single country and its capital. 
I would like to implement the checking of the answer using this endpoint but, again, I feel that this is functional and will have to do for now. 

