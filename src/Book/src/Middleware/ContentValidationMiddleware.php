<?php

namespace Book\Middleware;

use Book\Exception;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\InputFilter\InputFilter;
use Zend\ProblemDetails\ProblemDetailsResponseFactory;

class ContentValidationMiddleware implements MiddlewareInterface
{
    /**
     * @var InputFilter
     */
    private $filter;

    /**
     * @var string
     */
    private $validationType;

    public function __construct(
        InputFilter $filter,
        string $validationType
    ) {
        $this->filter = $filter;
        $this->validationType = $validationType;
    }

    /**
     * @var ServerRequestInterface $request
     * @var DelegateInterface $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $this->filter->setData($request->getParsedBody());
        if (! $this->filter->isValid()) {
            throw Exception\ValidationException::forType(
                $this->validationType,
                $this->filter->getMessages()
            );
        }

        return $delegate->process(
            $request->withParsedBody($this->filter->getValues())
        );
    }
}
