<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JournalRepository")
 */
class Journal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ecriture", mappedBy="idJournal")
     */
    private $ecritures;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Societe", inversedBy="journals")
     */
    private $idSociete;

    public function __construct()
    {
        $this->ecritures = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelleJournal): self
    {
        $this->libelle = $libelleJournal;

        return $this;
    }

    /**
     * @return Collection|Ecriture[]
     */
    public function getEcritures(): Collection
    {
        return $this->ecritures;
    }

    public function addEcriture(Ecriture $ecriture): self
    {
        if (!$this->ecritures->contains($ecriture)) {
            $this->ecritures[] = $ecriture;
            $ecriture->setIdJournal($this);
        }

        return $this;
    }

    public function removeEcriture(Ecriture $ecriture): self
    {
        if ($this->ecritures->contains($ecriture)) {
            $this->ecritures->removeElement($ecriture);
            // set the owning side to null (unless already changed)
            if ($ecriture->getIdJournal() === $this) {
                $ecriture->setIdJournal(null);
            }
        }

        return $this;
    }

    public function getIdSociete(): ?Societe
    {
        return $this->idSociete;
    }

    public function setIdSociete(?Societe $idSociete): self
    {
        $this->idSociete = $idSociete;

        return $this;
    }
}
