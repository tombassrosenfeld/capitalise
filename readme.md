# Capialise

Welcome to capitalise. 

## Setup



## Architectural decisions

I initially considered using a facade and/or interfaces for the CapitalCitiesData service. This would enable swapping it out the service used should a better alternative present itself. However, this felt like overkill for a project this simple at this stage of development.

I opted to call for the countries data every time it's used rather than using the database and creating a countries table with entries added to the DB table and a related model. This is largely because I felt that this data represents third party data that _could_ change, even if it's not likely. Additionally, with caching, these requests should be captured and we would likely use the cached response. 

## Out of scope goals

I would like to implement a history that would prevent the user being presented with the same country within a reasonable timeframe. This could either be implemented on the front end and be confined to the current session, or we could use authenticated users and keep a record of each user's history. I would also use this to record streak data and keep track of the user's high score. 

In lieu of persistence of the user's history, I would use session storage to keep a track of their current streak and longest streak by creating a useSessionStorage hook.
