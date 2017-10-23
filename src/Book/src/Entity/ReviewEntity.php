<?php
namespace Book\Entity;

class ReviewEntity
{
    /**
     * @var string Unique identifier of the book; UUIDv4 value.
     */
    public $id;

    /**
     * @var string Username of the review author
     */
    public $username;

    /**
     * @var string Book Id of the book
     */
    public $book_id;

    /**
     * @var string Review
     */
    public $review;

    /**
     * @var int Number of stars between 0 and 5
     */
    public $stars;
}
