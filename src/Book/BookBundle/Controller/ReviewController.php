<?php

namespace Book\BookBundle\Controller;

use Book\BookBundle\Entity\Review;
use Book\BookBundle\Form\ReviewType;
use Book\BookBundle\Services\BookService;
use Book\BookBundle\Services\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReviewController extends Controller
{
    private $bookService;
    private $reviewService;

    public function __construct(BookService $bookService, ReviewService $reviewService)
    {
        $this->bookService = $bookService;
        $this->reviewService = $reviewService;
    }

    public function viewAction($id)
    {
        $review = $this->reviewService->findReview($id);
        return $this->render('BookBookBundle:Review:view.html.twig', [
            'review' => $review
        ]);
    }

    public function createAction(Request $request, $id)
    {
        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review,[
            'action' => $request->getUri()
        ]);

        $form->handleRequest($request);


        $book = $this->bookService->findBook($id);

        if($form->isValid()) {
            $review->setAuthor($this->getUser());
            $review->setBook($book);
            $review->setTimestamp(new \DateTime());
            $this->reviewService->addReview($review);

            $this->addFlash('success', 'Successfully created your review!');
            return $this->redirect($this->generateUrl('review_view', [
                'id' => $review->getId()
            ]));
        }

        return $this->render('BookBookBundle:Review:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, Request $request)
    {
        $isAuthor = $this->reviewService->isAuthor($id, $this->getUser());
        if (!$isAuthor) {
            $this->addFlash('danger', 'Only original author can edit a review');
            return $this->redirectToRoute('review_view', [
                'id' => $id
            ]);
        }
        $review = $this->reviewService->findReview($id);
        $form = $this->createForm(ReviewType::class, $review, [
            'action' => $request->getUri()
        ]);

        $form->handleRequest($request);

        if($form->isValid()) {
            $this->reviewService->updateReview($review);
            $this->addFlash('success', 'Successfully edited your review!');
            return $this->redirect($this->generateUrl('review_view', [
                'id' => $review->getId()
            ]));
        }

        return $this->render('BookBookBundle:Review:edit.html.twig', [
            'form' => $form->createView(),
            'review' => $review
        ]);
    }

    public function deleteAction($id)
    {
        $review = $this->reviewService->findReview($id);
        if (!$review->isAuthor($this->getUser())) {
            $this->addFlash('danger', 'Only original author can delete a review');
            return $this->redirectToRoute('review_view', [
                'id' => $id
            ]);
        }

        $this->reviewService->deleteReview($review);
        $this->addFlash('success', 'Review successfully deleted!');
        return $this->redirect($this->generateUrl('index'));
    }

    public function listAllReviewsAction(Request $request)
    {
        $reviews = $this->reviewService->getAllReviewsPaginated($request);
        return $this->render('BookBookBundle:Page:reviews.html.twig', [
            'reviews' => $reviews
        ]);
    }
}
