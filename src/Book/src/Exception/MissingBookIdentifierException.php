<?php

namespace Book\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsException;
use Zend\ProblemDetails\Exception\ProblemDetailsException;

class MissingBookIdentifierException extends DomainException implements
    ExceptionInterface,
    ProblemDetailsException
{
    use CommonProblemDetailsException;

    public function __construct()
    {
        $this->status = 400;
        $this->title  = 'Client Error';
        $this->type   = 'book.id';
        $this->detail = 'Missing book identifier';

        parent::__construct($this->detail, $this->status);
    }
}
