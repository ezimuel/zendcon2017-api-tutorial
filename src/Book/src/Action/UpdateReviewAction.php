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

class UpdateReviewAction implements MiddlewareInterface
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
        $id   = $request->getAttribute('id');
        $user = $request->getAttribute(UserInterface::class, false);
        if (false === $user) {
            throw new Exception\UserNotAuthenticatedException();
        }
        $review = $this->createReviewFromFilteredData($id, $request->getParsedBody());
        $user = $request->getAttribute(UserInterface::class);

        if (!$this->checkUserAuthorization($id, $user)) {
            throw new Exception\UserNotAuthorizedException();
        }
        $review = $this->review->update($review, $user->getUsername());

        $resource = $this->resourceGenerator->fromObject($review, $request);
        return $this->responseFactory->createResponse($request, $resource);
    }

    private function createReviewFromFilteredData(string $id, array $values) : ReviewEntity
    {
        if (isset($values['book_id']) && !$this->review->bookIdExists($values['book_id'])) {
            throw Exception\ValidationException::forType(
                Exception\ValidationException::REVIEW_ADD,
                [ sprintf("The %s book_id doesn't exist", $values['book_id']) ]
            );
        }
        $review = new ReviewEntity();

        $review->id      = $id;
        $review->review  = $values['review'] ?? null;
        $review->stars   = $values['stars'] ?? null;
        $review->book_id = $values['book_id'] ?? null;

        return $review;
    }

    private function checkUserAuthorization(string $review_id, UserInterface $user): bool
    {
        $review = $this->review->getReview($review_id);
        if (empty($review)) {
            return false;
        }
        if ($review->username === $user->getUsername()) {
            return true;
        }
        return $user->getRole() === 'admin';
    }
}
