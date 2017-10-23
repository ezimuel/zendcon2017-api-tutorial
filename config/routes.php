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

$app->post('/reviews', [
    Zend\Expressive\Authentication\AuthenticationMiddleware::class,
    Zend\ProblemDetails\ProblemDetailsMiddleware::class,
    Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware::class,
    Book\Middleware\AddReviewValidationMiddleware::class,
    Book\Action\AddReviewAction::class
]);

$app->patch('/reviews/{id}', [
    Zend\Expressive\Authentication\AuthenticationMiddleware::class,
    Zend\ProblemDetails\ProblemDetailsMiddleware::class,
    Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware::class,
    Book\Middleware\UpdateReviewValidationMiddleware::class,
    Book\Action\UpdateReviewAction::class
]);
