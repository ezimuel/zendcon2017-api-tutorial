<?php
namespace Book\Entity;

class BookEntity
{
    /**
     * @var string Unique identifier of the book; UUIDv4 value.
     */
    public $id;

    /**
     * @var string Title of the book.
     */
    public $title;

    /**
     * @var string Author of the book.
     */
    public $author;

    /**
     * @var string Publisher of the book.
     */
    public $publisher;

    /**
     * @var int Number of book pages.
     */
    public $pages;

    /**
     * @var int Year of the book.
     */
    public $year;

    /**
     * @var string ISBN of the book (13 digits)
     */
    public $isbn;
}
