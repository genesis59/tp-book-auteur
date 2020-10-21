<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Auteur::class, inversedBy="book",cascade={"persist"})
     */
    private $auteur;

    /**
     * @ORM\ManyToOne(targetEntity=Editeur::class, inversedBy="book")
     * @ORM\JoinColumn(nullable=true)
     */
    private $editeur;


    /**
     * @ORM\ManyToOne(targetEntity=Genre::class, inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    /**
     * @ORM\ManyToMany(targetEntity=Tags::class)
     */
    private $tags;

    public function __construct()
    {
        $this->auteur = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */
    public function getAuteur(): Collection
    {
        return $this->auteur;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->auteur->contains($auteur)) {
            $this->auteur[] = $auteur;
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        if ($this->auteur->contains($auteur)) {
            $this->auteur->removeElement($auteur);
        }

        return $this;
    }

    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * @return Collection|Tags[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tags $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tags $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }
}
