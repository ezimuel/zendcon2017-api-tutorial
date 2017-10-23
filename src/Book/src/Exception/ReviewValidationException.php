<?php

namespace Book\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsException;
use Zend\ProblemDetails\Exception\ProblemDetailsException;

class ReviewValidationException extends DomainException implements
    ExceptionInterface,
    ProblemDetailsException
{
    use CommonProblemDetailsException;

    const TYPE_ADD = 'book.create.validation_failure';
    const TYPE_UPDATE = 'book.update.validation_failure';

    public static function forType(string $type, array $messages) : self
    {
        $message = 'Validation of the book details failed';
        $code    = 422;

        $instance = new self($message, $code);
        $instance->status = $code;
        $instance->title  = 'Book Validation Failed';
        $instance->type   = $type;
        $instance->detail = $message;
        $instance->additional = [
            'validation_messages' => $messages,
        ];

        return $instance;
    }
}
