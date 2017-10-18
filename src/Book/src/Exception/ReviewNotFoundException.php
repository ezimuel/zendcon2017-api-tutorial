<?php

namespace Book\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsException;
use Zend\ProblemDetails\Exception\ProblemDetailsException;

class ReviewNotFoundException extends DomainException implements
    ExceptionInterface,
    ProblemDetailsException
{
    use CommonProblemDetailsException;

    public static function forReview(string $id) : self
    {
        $message  = sprintf('Review could not be retrieved with identifier %s', $id);
        $instance = new self($message, 404);

        $instance->status = 404;
        $instance->title  = 'Review not found';
        $instance->type   = 'review.not_found';
        $instance->detail = sprintf('Review could not be retrieved with identifier %s', $id);
        $instance->additional = ['review_id' => $id];
        return $instance;
    }
}
