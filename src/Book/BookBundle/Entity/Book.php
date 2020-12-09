<?php

namespace Book\BookBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Book
 *
 * @ORM\Table(name="book")
 * @ORM\Entity
 * @UniqueEntity("isbn", errorPath="isbn", message="Book already exists")
 * @Vich\Uploadable
 */
class Book
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
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=13, unique=true)
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Isbn(
     *      message = "This ISBN number is not  valid."
     * )
     *
     */
    private $isbn;

    /**
     * @ORM\Column(type="boolean", options={"default":"0"})
     */
    private $isApproved = false;

    /**
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="book_image", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="summary_of_book", type="text", nullable=true)
     */
    private $summaryOfBook;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Book\BookBundle\Entity\Review", mappedBy="book", cascade={"persist", "remove"}, orphanRemoval=true, fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(name="review_id", referencedColumnName="id")
     */
    protected $reviews;

    public function __construct()
    {
        $this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString(){
        return (string) $this->getTitle();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        //Update the timestamp for the entity
        $this->setTimestamp(new \DateTime());
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getIsbn()
    {
        return $this->isbn;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function setSummaryOfBook($summaryOfBook)
    {
        $this->summaryOfBook = $summaryOfBook;

        return $this;
    }

    public function getSummaryOfBook()
    {
        return $this->summaryOfBook;
    }

    public function addReview(Review $review)
    {
        $this->reviews[] = $review;

        return $this;
    }

    public function removeReview(Review $review)
    {
        return $this->reviews->removeElement($review);
    }

    public function getReviews()
    {
        return $this->reviews;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        dump($image);

        //Must update at least one field in doctrine for event listeners to be called and update image
        if ($image) {
            $this->timestamp = new \DateTime();
        }

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setIsApproved($isApproved)
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    public function getIsApproved()
    {
        return $this->isApproved;
    }
}
