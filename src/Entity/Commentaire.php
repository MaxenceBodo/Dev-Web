<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * email du créateur du commentaire
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * Le commentaire
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * Affiche si le commentaire est actif ou pas
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * Date de création du commentaire
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * Renvoie à l'event sur lequel est posté le commentaire
     * Loesqu'un event est supprimé tous ces commentaires sont aussi supprimés
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="commentaires")
     * @ORM\JoinColumn(name="event_id",referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getcreated_at(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setcreated_at(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
