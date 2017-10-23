# Building Middleware Web APIs in PHP 7 with Expressive

## ZendCon 2017 tutorial

This repository contains the source code of "Building Middleware Web APIs in PHP
7 with Expressive" ZendCon 2017 tutorial.

In order to run the tutorial you need to install the dependencies using
[composer](https://getcomposer.org/):

```bash
composer install
```

This tutorial uses the `data\books.sq3` SQLite database. The database schema is
stored in [data/db.sql](data/db.sql) file.


## API documentation

This tutorial provides the following APIs:

### GET /books

### GET /books/{id}

### GET /reviews

### GET /reviews/{id}

### POST /reviews

```json
{
    "book_id" : "UUID of the reviewed book",
    "review"  : "Text of the review",
    "stars"   : "A number between 1 and 5"
}
```

### PATCH /reviews/{id}

One or more of the following values:

```json
{
    "book_id" : "UUID of the reviewed book",
    "review"  : "Text of the review",
    "stars"   : "A number between 1 and 5"
}
```

**Note:** The POST and the PATCH actions require authentication, provided using
[Basic Access Authentication](https://en.wikipedia.org/wiki/Basic_access_authentication].
We provided 3 users to test: `user1`, `user2` and `admin`. The first two are
general users, the last one has an administrator role. The passwords of all the
users is `password`.

```

(C) Copyright 2017 by [Enrico Zimuel](https://www.zimuel.it/), [Rogue Wave Sofware](https://www.roguewave.com/)
Inc.
