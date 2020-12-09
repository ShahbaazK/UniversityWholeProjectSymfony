<?php

namespace Book\BookBundle\Services;

use Book\BookBundle\Entity\Review;
use Book\BookBundle\Entity\User;
use Book\BookBundle\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Request;

class ReviewService
{
    private $repository;
    private $paginationSerivce;

    public function __construct(ReviewRepository $reviewRepository, PaginationService $paginationService)
    {
        $this->repository = $reviewRepository;
        $this->paginationSerivce = $paginationService;
    }

    public function findReview($id)
    {
        return $this->repository->find($id);
    }

    public function getLatestReviews($limit, $offset)
    {
        return $this->repository->getLatestReviews($limit, $offset)->execute();
    }

    public function getAllReviews()
    {
        return $this->repository->getAllReviews();
    }

    public function getAllReviewsPaginated(Request $request)
    {
        $reviews = $this->getAllReviews();
        return $this->paginationSerivce->createPaginator($reviews, 5, $request);
    }

    public function reviewsForBookPaginated($id, Request $request)
    {
        $reviews = $this->repository->reviewsForBook($id);
        return $this->paginationSerivce->createPaginator($reviews, 3, $request);
    }

    public function getReviewsByUser($userId)
    {
        return $this->repository->getReviewsByUser($userId);
    }

    public function addReview(Review $review)
    {
        $this->repository->addUpdateReview($review);
    }

    public function updateReview(Review $review)
    {
        $this->repository->addUpdateReview($review);
    }

    public function deleteReview(Review $review)
    {
        $this->repository->deleteReview($review);
    }

    public function isAuthor($id, User $user)
    {
        $review = $this->findReview($id);
        return $review->isAuthor($user);
    }
}