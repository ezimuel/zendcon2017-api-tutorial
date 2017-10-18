<?php
namespace Book\Action;

use Book\Model\ReviewModel;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class ReviewAction implements MiddlewareInterface
{
    protected $review;
    protected $responseFactory;
    protected $resourceGenerator;

    public function __construct(
        ReviewModel $review,
        HalResponseFactory $responseFactory,
        ResourceGenerator $resourceGenerator
    ) {
        $this->review = $review;
        $this->responseFactory = $responseFactory;
        $this->resourceGenerator = $resourceGenerator;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $id = $request->getAttribute('id', false);
        if (false === $id) {
            throw new MissingReviewIdentifierException();
        }

        $review = $this->review->getReview($id);
        $resource = $this->resourceGenerator->fromObject($review, $request);
        // $resource = $resource->withLink($this->generateSearchLink(
        //     $this->resourceGenerator->getLinkGenerator(),
        //     $request
        // ));

        return $this->responseFactory->createResponse($request, $resource);

    }
}
