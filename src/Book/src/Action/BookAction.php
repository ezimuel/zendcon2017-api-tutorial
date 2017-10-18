<?php
namespace Book\Action;

use Book\Model\BookModel;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class BookAction implements MiddlewareInterface
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
        $id = $request->getAttribute('id', false);
        if (false === $id) {
            throw new MissingBookIdentifierException();
        }

        $book = $this->book->getBook($id);
        $resource = $this->resourceGenerator->fromObject($book, $request);
        // $resource = $resource->withLink($this->generateSearchLink(
        //     $this->resourceGenerator->getLinkGenerator(),
        //     $request
        // ));

        return $this->responseFactory->createResponse($request, $resource);

    }
}
