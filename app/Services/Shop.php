<?php

namespace App\Services;

class Shop
{
    public array $books = [];

    /**
     * @param Book $book
     * @return void
     */
    public function bookAdd(Book $book): void
    {
        $this->books[] = $book;
    }

    /**
     * @param $title
     * @return mixed|null
     */
    public function bookGet($title): mixed
    {
        foreach ($this->books as $key => $book) {
            if ($book->getTitle() == $title) {
                unset($this->books[$key]);
                return $book;
            }
        }

        return NULL;
    }

    /**
     * @param $title
     * @return bool
     */
    public function bookIsAvailable($title): bool
    {
        foreach ($this->books as $book) {
            if ($book->getTitle() === $title) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * @param $author
     * @return array
     */
    public function bookListByAuthor($author): array
    {
        $booksByAuthor = [];
        foreach ($this->books as $book) {
            if ($book->getAuthor() === $author) {
                $booksByAuthor[] = $book->getTitle();
            }
        }
        return $booksByAuthor;
    }

    /**
     * @param $partialTitle
     * @return array
     */
    public function bookListByTitleContains($partialTitle): array
    {
        $matchingBooks = [];
        foreach ($this->books as $book) {
            if (stripos($book->getTitle(), $partialTitle) !== FALSE) {
                $matchingBooks[] = $book;
            }
        }
        return $matchingBooks;
    }
}