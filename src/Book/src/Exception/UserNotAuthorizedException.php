<?php

namespace Book\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsException;
use Zend\ProblemDetails\Exception\ProblemDetailsException;

class UserNotAuthorizedException extends DomainException implements
    ExceptionInterface,
    ProblemDetailsException
{
    use CommonProblemDetailsException;

    public function __construct()
    {
        $this->status = 403;
        $this->title  = 'Forbidden';
        $this->type   = 'user';
        $this->detail = 'User is not authorized to perform the requested operation';

        parent::__construct($this->detail, $this->status);
    }
}
