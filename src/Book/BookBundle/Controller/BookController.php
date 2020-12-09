<?php

namespace Book\BookBundle\Controller;

use Book\BookBundle\Entity\Book;
use Book\BookBundle\Form\BookType;
use Book\BookBundle\Services\BookService;
use Book\BookBundle\Services\ReviewService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Book controller.
 *
 */
class BookController extends Controller
{
    private $bookService;
    private $reviewService;

    public function __construct(BookService $bookService, ReviewService $reviewService)
    {
        $this->bookService = $bookService;
        $this->reviewService= $reviewService;
    }

    public function viewAction($id, Request $request)
    {
        $book = $this->bookService->findBook($id);
        $reviews = $this->reviewService->reviewsForBookPaginated($id, $request);

        if (!$book) {
            $this->addFlash('danger', 'The book you are trying to view has not been approved yet!');
            return $this->redirectToRoute('index');
        }

        return $this->render('BookBookBundle:Book:view.html.twig', [
            'book' => $book,
            'reviews' => $reviews
        ]);
    }

    public function createAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book,[
            'action' => $request->getUri()
        ]);

        $form->handleRequest($request);

        if($form->isValid()) {
            $this->bookService->addBook($book);
            $this->addFlash('success', 'Book request has been sent to the admin for approval!');
            return $this->redirect($this->generateUrl('book_list', [
                'id' => $book->getId()
            ]));
        }

        return $this->render('BookBookBundle:Book:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function editAction($id, Request $request)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Only admins can edit books!');
            return $this->redirectToRoute('book_view', [
                'id' => $id
            ]);
        }

        $book = $this->bookService->findBook($id);
        $form = $this->createForm(BookType::class, $book, [
            'action' => $request->getUri()
        ]);

        $form->handleRequest($request);
        if($form->isValid()) {
            $this->bookService->addBook($book);
            $this->addFlash('success', 'Books successfully edited!');
            return $this->redirect($this->generateUrl('book_view', [
                'id' => $book->getId()
            ]));
        }

        return $this->render('BookBookBundle:Book:edit.html.twig', [
            'form' => $form->createView(),
            'book' => $book
        ]);
    }

    public function deleteAction($id)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', 'Only admins can delete books!');
            return $this->redirectToRoute('book_view',[
                'id' => $id
            ]);
        }

        $this->bookService->deleteBook($id);
        $this->addFlash('success', 'Book successfully deleted!');
        return $this->redirect($this->generateUrl('index'));
    }

    public function listAllBooksAction(Request $request)
    {
        $books = $this->bookService->getAllBooksPaginated($request);
        return $this->render('BookBookBundle:Page:books.html.twig', [
            'books' => $books
        ]);
    }
}
