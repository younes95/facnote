<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExerciceRepository")
 */
class Exercice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $libelleExercice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Societe", inversedBy="exercices")
     */
    private $idSociete;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ecriture", mappedBy="idExercice")
     */
    private $ecritures;

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
        return $this->libelleExercice;
    }

    public function setLibelle(?string $libelleExercice): self
    {
        $this->libelleExercice = $libelleExercice;

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
            $ecriture->setIdExercice($this);
        }

        return $this;
    }

    public function removeEcriture(Ecriture $ecriture): self
    {
        if ($this->ecritures->contains($ecriture)) {
            $this->ecritures->removeElement($ecriture);
            // set the owning side to null (unless already changed)
            if ($ecriture->getIdExercice() === $this) {
                $ecriture->setIdExercice(null);
            }
        }

        return $this;
    }
}
