<?php

namespace Book\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsException;
use Zend\ProblemDetails\Exception\ProblemDetailsException;

class ValidationException extends DomainException implements
    ExceptionInterface,
    ProblemDetailsException
{
    use CommonProblemDetailsException;

    const REVIEW_ADD = 'review.create.validation_failure';
    const REVIEW_UPDATE = 'review.update.validation_failure';

    public static function forType(string $type, array $messages) : self
    {
        $message = 'Validation of the review details failed';
        $code    = 422;

        $instance = new self($message, $code);
        $instance->status = $code;
        $instance->title  = 'Review Validation Failed';
        $instance->type   = $type;
        $instance->detail = $message;
        $instance->additional = [
            'validation_messages' => $messages,
        ];

        return $instance;
    }
}
