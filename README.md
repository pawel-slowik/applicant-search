Yet another job interview task.

## Business requirements

REST endpoint for a candidate search.

Each of candidates has fields like: email, first name, last name, date of
birth, tags, notes and content of the whole CV saved in the database (all
of this data is also indexed in the ElasticSearch).

This endpoint receives the phrase for search (limit 2000 characters) +
optionally date of birth (date range).

This endpoint allows to sorting and paginating.

This endpoint handles dynamic scope of returned data (by default returns
email, first name, last name; optionally can returns tags and/or notes for
each record).

This solution should be done in high level of abstraction. We won't run the
code, we want to see your way of thinking, class structure, techniques
used, so we accept PHP code, pseudocode or even UML diagrams.

## Requirements

- PHP 7.4
- Composer

## Instructions

1. install dependencies
```
composer install
```

2. run tests
```
composer test
```

3. start development server
```
composer dev
```

4. execute an example search
```
curl 'http://localhost:8080/applicant/?details' | jq
```

5. be amazed
