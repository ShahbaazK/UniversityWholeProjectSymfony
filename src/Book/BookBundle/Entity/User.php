<?php

namespace Book\BookBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="`user`")
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Book\BookBundle\Entity\Review", mappedBy="author")
     */
    protected $reviews;

    public function __construct()
    {
        parent::__construct();
        $this->reviews = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Add Review.
     * @param \Book\BookBundle\Entity\Review $review
     * @return User
     */
    public function addReview(Review $review)
    {
        $this->reviews[] = $review;
        return $this;
    }

    /**
     * Remove Review.
     * @param \Book\BookBundle\Entity\Review $review
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeReview(Review $review)
    {
        return $this->reviews->removeElement($review);
    }

    /**
     * Get Reviews.
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    public function hasReview(Review $review)
    {
        return $this->getReviews()->contains($review);
    }

    //To string for EasyAdminBundle
    public function __toString(){
        return (string) $this->getUsername();
    }
}
