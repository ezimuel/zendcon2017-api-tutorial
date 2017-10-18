<?php
namespace Book\Model;

use Book\Collection\ReviewCollection;
use Book\Entity\ReviewEntity;
use Book\Exception;
use Book\PdoPaginator;
use Book\PdoService;

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
        return $book;
    }
}
