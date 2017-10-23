<?php
namespace Book\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Book\Entity\ReviewEntity;
use Book\Exception;
use Book\Model\ReviewModel;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Hal\HalResponseFactory;
use Zend\Expressive\Hal\ResourceGenerator;
use Zend\ProblemDetails\ProblemDetailsResponseFactory;

class AddReviewAction implements MiddlewareInterface
{
    /** @var ReviewModel */
    private $review;

    /** @var ResourceGenerator */
    private $resourceGenerator;

    /** @var HalResponseFactory */
    private $responseFactory;

    public function __construct(
        ReviewModel $review,
        ResourceGenerator $resourceGenerator,
        HalResponseFactory $responseFactory
    ) {
        $this->review = $review;
        $this->resourceGenerator = $resourceGenerator;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $review = $this->createReviewFromFilteredData($request->getParsedBody());
        $user = $request->getAttribute(UserInterface::class, false);
        if (false === $user) {
            throw new Exception\UserNotAuthenticatedException();
        }
        $review = $this->review->create($review, $user->getUsername());
        $resource = $this->resourceGenerator->fromObject($review, $request);

        return $this->responseFactory->createResponse($request, $resource);
    }

    private function createReviewFromFilteredData(array $values) : ReviewEntity
    {
        if (!$this->review->bookIdExists($values['book_id'])) {
            throw Exception\ValidationException::forType(
                Exception\ValidationException::REVIEW_ADD,
                [ sprintf("The %s book_id doesn't exist", $values['book_id']) ]
            );
        }
        $review = new ReviewEntity();

        $review->review  = $values['review'];
        $review->stars   = $values['stars'];
        $review->book_id = $values['book_id'];

        return $review;
    }
}
