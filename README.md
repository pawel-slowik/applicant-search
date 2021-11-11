Yet another job interview task.

## „Business” requirements

Note that these aren't exactly _business_ requirements, because of the technical
details contained therein and because of the imposed solution. The original task
description follows:

REST endpoint for a candidate search.

Each candidate has fields like: email, first name, last name, date of
birth, tags, notes and content of the whole CV saved in the database (all
of this data is also indexed in the ElasticSearch).

The endpoint receives a search phrase (limit 2000 characters) and
optionally date of birth (date range).

The endpoint allows for sorting and paginating.

The endpoint handles dynamic scope of returned data (by default returns
email, first name, last name; optionally can return tags and/or notes for
each record).

The solution should be done in high level of abstraction. We won't run the
code, we want to see your way of thinking, class structure, techniques
used, so we accept PHP code, pseudocode or even UML diagrams.


## Analysis

The "dynamic scope of returned data" requirement is a red flag. _We need to
actively and openly work against it._

Why is it a red flag? Because a method should only return a single data type and
the same is true for a REST API endpoint. Returning multiple data types makes
the code harder to reason about and less maintainable in the long term.

What do I mean by "work against it"?

- Before implementing this feature, spend more time discussing actual use cases
  with the business stakeholders.

- Only if the discussion does not bring new insights, proceed with the "dynamic
  scope" implementation, but assume that it's going to change soon and therefore
  implement it in the cheapest (but still correct) way possible. This is why my
  implementation simply uses two models, basic and detailed, with a parameter to
  switch between them, instead of some complicated output schema definition
  mechanism.

- Refine the feature in following iterations.

Here are some possible refinement ideas:

- Create two endpoints: `/applicant/?search=whatever` that always includes
  candidate tags in its response (since tags are lightweight) and a separate
  endpoint for notes: `/applicant/123/notes` (since it's unlikely that the end
  user is going to read all the notes for each candidate found).

- Assuming that the dynamic nature of the returned data turns out to be
  indispensable, there are solutions other than REST for that. Namely, the
  ability to define an output schema for queries is a defining feature of
  GraphQL.


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
