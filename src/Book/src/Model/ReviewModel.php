<?php
namespace Book\Model;

use Book\Collection\BookReviewCollection;
use Book\Collection\ReviewCollection;
use Book\Entity\ReviewEntity;
use Book\Exception;
use Book\PdoPaginator;
use Book\PdoService;
use Ramsey\Uuid\Uuid;

class ReviewModel
{
    public function __construct(PdoService $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllReviews(): ReviewCollection
    {
        $statement = $this->pdo->prepare('SELECT * FROM review LIMIT :limit OFFSET :offset');
        $countStatement = $this->pdo->prepare('SELECT COUNT(id) FROM review');

        return new ReviewCollection(
            new PdoPaginator($statement, $countStatement, [], ReviewEntity::class)
        );
    }

    public function getReview(string $id): ReviewEntity
    {
        $statement = $this->pdo->prepare('SELECT * FROM review WHERE id = :id');
        $statement->execute([':id' => $id]);
        $statement->setFetchMode(PdoService::FETCH_CLASS, ReviewEntity::class);

        $review = $statement->fetch();
        if (! $review instanceof ReviewEntity) {
            throw Exception\ReviewNotFoundException::forReview($id);
        }
        return $review;
    }

    public function getReviewsByBook(string $book_id): BookReviewCollection
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM review WHERE book_id = :book_id'
        );
        $statement->execute([':book_id' => $book_id]);
        $statement->setFetchMode(PdoService::FETCH_CLASS, ReviewEntity::class);

        return new BookReviewCollection(
            $statement->fetchAll()
        );
    }

    public function create(ReviewEntity $review, string $user) : ReviewEntity
    {
        $review->id = Uuid::uuid4()->toString();
        $review->username = $user;

        $statement = $this->pdo->prepare(
            'INSERT INTO review (id, username, book_id, review, stars)
             VALUES (:id, :username, :book_id, :review, :stars)'
        );

        try {
            $result = $statement->execute([
                ':id'       => $review->id,
                ':username' => $review->username,
                ':book_id'  => $review->book_id,
                ':review'   => $review->review,
                ':stars'    => $review->stars
            ]);
        } catch (PDOException $e) {
            throw new Exception\BookNotCreatedException(
                'Could not add review to database',
                (int) $e->getCode(),
                $e
            );
        }

        return $review;
    }

    public function bookIdExists(string $book_id): bool
    {
        $statement = $this->pdo->prepare(
            'SELECT id FROM book WHERE id = :book_id'
        );
        $statement->execute([':book_id' => $book_id]);
        $row = $statement->fetch();

        return (isset($row['id']));
    }

    public function update(ReviewEntity $review, string $username): ReviewEntity
    {
        $values    = $this->aggregateNonNullProperties($review);
        $statement = $this->pdo->prepare($this->prepareUpdateQuery($values));

        try {
            $result = $statement->execute(
                $this->createUpdateValues($values, $review->id, $username)
            );
        } catch (PDOException $e) {
            throw new Exception\ReviewNotUpdatedException(
                'Could not update review in database',
                (int) $e->getCode(),
                $e
            );
        }

        return $this->getReview($review->id);
    }

    /**
     * Pull non-null review properties for an update operation.
     *
     * @param ReviewEntity $review
     * @return array Values for the update
     * @throws Exception\ReviewNotUpdatedException if no values are present.
     */
    private function aggregateNonNullProperties(ReviewEntity $review) : array
    {
        $values = [];
        foreach ((array) $review as $property => $value) {
            if (null === $value || in_array($property, ['id', 'user_id'])) {
                continue;
            }
            $values[$property] = $value;
        }

        if (empty($values)) {
            throw new Exception\ReviewNotUpdatedException(
                'No data to update',
                400
            );
        }

        return $values;
    }

    private function prepareUpdateQuery(array $values) : string
    {
        return sprintf(
            'UPDATE review SET %s WHERE id = :id AND username = :username',
            array_reduce(array_keys($values), function ($placeholders, $key) {
                if (! empty($placeholders)) {
                    $placeholders .= ', ';
                }
                $placeholders .= sprintf('%s = :%s', $key, $key);
                return $placeholders;
            }, '')
        );
    }

    private function createUpdateValues(array $values, string $id, string $username) : array
    {
        foreach ($values as $key => $value) {
            $placeholder = ':' . $key;
            unset($values[$key]);
            $values[$placeholder] = $value;
        }

        $values[':id'] = $id;
        $values[':username'] = $username;

        return $values;
    }
}
