<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Book;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbrBooks = null;

    

    



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getNbrBooks(): ?int
    {
        return $this->nbrBooks;
    }

    public function setNbrBooks(?int $nbr_books): static
    {
        $this->nbrBooks = $nbr_books;

        return $this;
    }
    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Book::class, cascade: ['persist', 'remove'])]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setAuthor($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            if ($book->getAuthor() === $this) {
                $book->setAuthor(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->username;
    }


    
    

    
}
