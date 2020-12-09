<?php

namespace Book\BookBundle\Services;

use Book\BookBundle\Entity\Book;
use Book\BookBundle\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;

class BookService
{
    private $repository;
    private $paginationService;

    public function __construct(BookRepository $bookRepository, PaginationService $paginationService)
    {
        $this->repository = $bookRepository;
        $this->paginationService = $paginationService;
    }

    public function findBook($id)
    {
        return $this->repository->find($id);
    }

    public function isApproved($id)
    {
        return $this->repository->isApproved($id);
    }

    public function getLatestBooks($limit, $offset)
    {
        return $this->repository->getLatestBooks($limit, $offset)->execute();
    }

    public function getAllBooks()
    {
        return $this->repository->getAllBooks();
    }

    public function getAllBooksPaginated(Request $request)
    {
        $books = $this->getAllBooks();
        return $this->paginationService->createPaginator($books, 6, $request);
    }

    public function addBook(Book $book)
    {
        $book->setTimestamp(new \DateTime());
        $this->repository->addUpdateBook($book);
    }

    public function updateBook(Book $book)
    {
        $book->setTimestamp(new \DateTime());
        $this->repository->addUpdateBook($book);
    }

    public function deleteBook($id)
    {
        $book = $this->repository->find($id);
        $this->repository->deleteBook($book);
    }
}