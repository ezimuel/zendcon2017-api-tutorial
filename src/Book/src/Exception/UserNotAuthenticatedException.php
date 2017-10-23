<?php

namespace Book\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsException;
use Zend\ProblemDetails\Exception\ProblemDetailsException;

class UserNotAuthenticatedException extends DomainException implements
    ExceptionInterface,
    ProblemDetailsException
{
    use CommonProblemDetailsException;

    public function __construct()
    {
        $this->status = 401;
        $this->title  = 'Unauthorized';
        $this->type   = 'user';
        $this->detail = 'User not authenticated';

        parent::__construct($this->detail, $this->status);
    }
}
