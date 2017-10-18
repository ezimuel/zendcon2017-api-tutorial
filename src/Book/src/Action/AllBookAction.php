<?php
namespace Book\Action;

use Book\Model\BookModel;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class AllBookAction implements MiddlewareInterface
{
    protected $book;
    protected $responseFactory;
    protected $resourceGenerator;

    public function __construct(
        BookModel $book,
        HalResponseFactory $responseFactory,
        ResourceGenerator $resourceGenerator
    ) {
        $this->book = $book;
        $this->responseFactory = $responseFactory;
        $this->resourceGenerator = $resourceGenerator;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $books = $this->book->getAllBooks();
        $resource = $this->resourceGenerator->fromObject($books, $request);
        // $resource = $resource->withLink($this->generateSearchLink(
        //     $this->resourceGenerator->getLinkGenerator(),
        //     $request
        // ));

        return $this->responseFactory->createResponse($request, $resource);

    }
}
