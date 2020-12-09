<?php

namespace Book\BookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="reviews")
 * @ORM\Entity
 */
class Review
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="review", type="text")
     */
    private $review;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;

    /**
     * @var \Book\BookBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Book\BookBundle\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * @var \Book\BookBundle\Entity\Book
     * @ORM\ManyToOne(targetEntity="Book\BookBundle\Entity\Book", inversedBy="reviews")
     * @ORM\JoinColumn(name="book", referencedColumnName="id")
     */
    private $book;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        //Update the timestamp for the entity
        $this->setTimestamp(new \DateTime());
        return $this->title;
    }

    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setAuthor(User $author)
    {
        $this->author = $author;
        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function isAuthor(User $user = null)
    {
        //If there is an author && their id matches the author id on the review
        return $user && $user->hasReview($this);
    }

    /**
     * Set book.
     *
     * @param \Book\BookBundle\Entity\Book|null $book
     *
     * @return Review
     */
    public function setBook(Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book.
     *
     * @return \Book\BookBundle\Entity\Book|null
     */
    public function getBook()
    {
        return $this->book;
    }

    //To string for EasyAdminBundle
    public function __toString(){
        return (string) $this->getTitle();
    }
}
