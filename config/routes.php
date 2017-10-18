<?php

$app->get('/books', [
    Zend\ProblemDetails\ProblemDetailsMiddleware::class,
    Book\Action\AllBookAction::class
], 'books');

$app->get('/books/{id}', [
    Zend\ProblemDetails\ProblemDetailsMiddleware::class,
    Book\Action\BookAction::class
], 'book');

$app->get('/reviews', [
    Zend\ProblemDetails\ProblemDetailsMiddleware::class,
    Book\Action\AllReviewAction::class
], 'reviews');

$app->get('/reviews/{id}', [
    Zend\ProblemDetails\ProblemDetailsMiddleware::class,
    Book\Action\ReviewAction::class
], 'review');
