<?php

namespace Book\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsException;
use Zend\ProblemDetails\Exception\ProblemDetailsException;

class ReviewNotUpdatedException extends DomainException implements
    ExceptionInterface,
    ProblemDetailsException
{
    use CommonProblemDetailsException;

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        $this->status = 500;
        $this->detail = 'An error occurred updating the review in the database';
        $this->title  = 'Review update error';
        $this->type   = 'review.create.update_error';

        parent::__construct($message, $code, $previous);
    }
}
