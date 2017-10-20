<?php
namespace Book\Model;

use Book\Collection\BookCollection;
use Book\Entity\BookEntity;
use Book\Entity\ReviewEntity;
use Book\Exception;
use Book\PdoPaginator;
use Book\PdoService;

class BookModel
{
    public function __construct(PdoService $pdo, ReviewModel $reviewModel)
    {
        $this->pdo = $pdo;
        $this->reviewModel = $reviewModel;
    }

    public function getAllBooks(): BookCollection
    {
        $statement = $this->pdo->prepare('SELECT * FROM book LIMIT :limit OFFSET :offset');
        $countStatement = $this->pdo->prepare('SELECT COUNT(id) FROM book');

        return new BookCollection(
            new PdoPaginator($statement, $countStatement, [], BookEntity::class)
        );
    }

    public function getBook(string $id): BookEntity
    {
        $statement = $this->pdo->prepare('SELECT * FROM book WHERE id = :id');
        $statement->execute([':id' => $id]);
        $statement->setFetchMode(PdoService::FETCH_CLASS, BookEntity::class);

        $book = $statement->fetch();
        if (! $book instanceof BookEntity) {
            throw Exception\BookNotFoundException::forBook($id);
        }
        return $book;
    }
}
