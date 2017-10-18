<?php
namespace Book\Action;

use Book\Model\ReviewModel;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;

class AllReviewAction implements MiddlewareInterface
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
        $reviews = $this->review->getAllReviews();
        $resource = $this->resourceGenerator->fromObject($reviews, $request);
        // $resource = $resource->withLink($this->generateSearchLink(
        //     $this->resourceGenerator->getLinkGenerator(),
        //     $request
        // ));

        return $this->responseFactory->createResponse($request, $resource);

    }
}
