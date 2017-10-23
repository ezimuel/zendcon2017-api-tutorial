<?php

namespace Book\Middleware;

use Book\Action;
use Book\Exception;
use Book\InputFilter;
use Psr\Container\ContainerInterface;
use Zend\ProblemDetails\ProblemDetailsResponseFactory;

class ContentValidationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container, string $requestedName) : ContentValidationMiddleware
    {
        $filters = $container->get('InputFilterManager');

        switch ($requestedName) {
            case AddReviewValidationMiddleware::class:
                $filter = $filters->get(InputFilter\Review::class);
                $validationType = Exception\ValidationException::REVIEW_ADD;
                break;
            case UpdateReviewValidationMiddleware::class:
                $filter = $filters->get(InputFilter\Review::class);
                $filter->get('book_id')->setRequired(false);
                $filter->get('review')->setRequired(false);
                $filter->get('stars')->setRequired(false);
                $validationType = Exception\ValidationException::REVIEW_UPDATE;
                break;
            default:
                throw new Exception\RuntimeException(sprintf(
                    "Cannot find the filter for %s",
                    $requestedName
                ));
        }

        return new ContentValidationMiddleware(
            $filter,
            $validationType
        );
    }
}
