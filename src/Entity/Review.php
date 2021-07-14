<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="review", indexes={@ORM\Index(name="hotel_id", columns={"hotel_id"}), @ORM\Index(name="idx_date", columns={"created_date"})})
 * @ORM\Entity
 */
class Review
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="score", type="boolean", nullable=false)
     */
    private $score;

    /**
     * @var string|null
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="date", nullable=false)
     */
    protected $created_date;

    /**
     * @var Hotel
     *
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hotel_id", referencedColumnName="id")
     * })
     */
    private $hotel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->created_date = $createdDate;

        return $this;
    }

    /**
     * @return Hotel
     */
    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }


}
