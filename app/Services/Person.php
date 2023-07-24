<?php

namespace App\Services;

class Person
{
    public string $name;
    public array $bag = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param Book $book
     * @return void
     */
    public function addToBag(Book $book): void
    {
        $this->bag[] = $book;
    }

    /**
     * @param $title
     * @return void
     */
    public function removeFromBag($title): void
    {
        foreach ($this->bag as $key => $book) {
            if ($book->getTitle() === $title) {
                unset($this->bag[$key]);
                return;
            }
        }
    }

    /**
     * @return int
     */
    public function countBag(): int
    {
        return count($this->bag);
    }
}