<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @ORM\Entity(repositoryClass=EventRepository::class) 
 * @ORM\Entity()
 * @ORM\Table(name="Event")
 * @ORM\HasLifecycleCallbacks()
 */
class Event extends AbstractController
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Nom de l'utilisateur
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * Type de l'évenements
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * Le lieux ou se déroule l'évenement
     * @ORM\Column(type="string", length=255)
     */
    private $lieux;

    /**
     * La date de l'évenement
     * @ORM\Column(type="date")
     */
    private $date;
    
    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * Créateur de l'évenement
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="events")
     */
    private $createur;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="event", cascade={"remove"})
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getLieux(): ?string
    {
        return $this->lieux;
    }

    public function setLieux(string $lieux): self
    {
        $this->lieux = $lieux;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setEvent($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEvent() === $this) {
                $commentaire->setEvent(null);
            }
        }

        return $this;
    }
}