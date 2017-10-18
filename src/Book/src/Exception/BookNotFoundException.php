<?php

namespace Book\Exception;

use DomainException;
use Zend\ProblemDetails\Exception\CommonProblemDetailsException;
use Zend\ProblemDetails\Exception\ProblemDetailsException;

class BookNotFoundException extends DomainException implements
    ExceptionInterface,
    ProblemDetailsException
{
    use CommonProblemDetailsException;

    public static function forBook(string $id) : self
    {
        $message  = sprintf('Book could not be retrieved with identifier %s', $id);
        $instance = new self($message, 404);

        $instance->status = 404;
        $instance->title  = 'Book not found';
        $instance->type   = 'book.not_found';
        $instance->detail = sprintf('Book could not be retrieved with identifier %s', $id);
        $instance->additional = ['book_id' => $id];
        return $instance;
    }
}
