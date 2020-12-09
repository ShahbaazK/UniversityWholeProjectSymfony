<?php

namespace Book\BookBundle\Repository;

use Book\BookBundle\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class BookRepository
{
    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Book::class);
        $this->entityManager = $entityManager;
    }

    public function getLatestBooks($limit, $offset)
    {
        $query = $this->repository->createQueryBuilder('book')
            ->andWhere('book.isApproved = 1')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('book.timestamp', 'DESC')
            ->getQuery();

        return $query;
    }

    public function getAllBooks()
    {
        $query = $this->repository->createQueryBuilder('book')
            ->andWhere('book.isApproved = 1')
            ->orderBy('book.timestamp', 'DESC')
            ->getQuery();

        return $query;
    }

    public function addUpdateBook(Book $book)
    {
        $this->entityManager->persist($book);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function deleteBook(Book $book)
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function find($id)
    {
        $book = $this->repository->find($id);
        if(!$book->getIsApproved())
        {
            return false;
        }

        return $book;
    }

    public function isApproved($id)
    {
        $query = $this->repository->createQueryBuilder('book')
            ->andWhere('book.isApproved = 1')
            ->andWhere('book.id = :bookId')
            ->setParameter('bookId', $id)
            ->orderBy('book.timestamp', 'DESC')
            ->getQuery()
            ->getResult();

        return $query;
    }
}