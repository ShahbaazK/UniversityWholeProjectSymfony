<?php

namespace Book\BookBundle\Controller;

use Book\BookBundle\Services\BookService;
use Book\BookBundle\Services\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    private $bookService;
    private $reviewService;

    public function __construct(BookService $bookService, ReviewService $reviewService)
    {
        $this->bookService = $bookService;
        $this->reviewService = $reviewService;
    }

    public function indexAction()
    {
        $books = $this->bookService->getLatestBooks(3,0);
        $reviews = $this->reviewService->getLatestReviews(3, 0);

        return $this->render('BookBookBundle:Page:index.html.twig', [
            'books' => $books,
            'reviews' => $reviews
        ]);
    }

    public function aboutAction()
    {
        return $this->render('BookBookBundle:Page:about.html.twig');
    }
}
