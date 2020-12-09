<?php

namespace Book\BookBundle\Repository;

use Book\BookBundle\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class ReviewRepository
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
        $this->repository = $entityManager->getRepository(Review::class);
        $this->entityManager = $entityManager;
    }

    public function getLatestReviews($limit, $offset)
    {
         $query = $this->repository->createQueryBuilder('review')
            ->join('review.book', 'book')
            ->andWhere('book.isApproved = 1')
            ->orderBy('review.timestamp', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery();

        return $query;
    }

    public function getAllReviews()
    {
        $query = $this->repository->createQueryBuilder('review')
            ->join('review.book', 'book')
            ->andWhere('book.isApproved = 1')
            ->orderBy('review.timestamp', 'DESC')
            ->getQuery();

        return $query;
    }

    public function getReviewsByUser($userId)
    {
        $query = $this->repository->createQueryBuilder('review')
            ->where('review.author = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('review.timestamp', 'DESC')
            ->getQuery()
            ->execute();

        return $query;
    }

    public function addUpdateReview(Review $review)
    {
        $this->entityManager->persist($review);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function deleteReview(Review $review)
    {
        $this->entityManager->remove($review);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function reviewsForBook($id)
    {
        $query = $this->repository->createQueryBuilder('review')
            ->where('review.book = :id')
            ->setParameter('id', $id)
            ->orderBy('review.timestamp', 'DESC')
            ->getQuery()
            ->execute();

        return $query;
    }
}