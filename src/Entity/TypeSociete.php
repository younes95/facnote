<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeSocieteRepository")
 */
class TypeSociete
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
    private $nomTypeSociete;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Societe", mappedBy="idTypeSociete")
     */
    private $societes;

    public function __construct()
    {
        $this->societes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNomTypeSociete(): ?string
    {
        return $this->nomTypeSociete;
    }

    public function setNomTypeSociete(string $nomTypeSociete): self
    {
        $this->nomTypeSociete = $nomTypeSociete;

        return $this;
    }

    /**
     * @return Collection|Societe[]
     */
    public function getSocietes(): Collection
    {
        return $this->societes;
    }

    public function addSociete(Societe $societe): self
    {
        if (!$this->societes->contains($societe)) {
            $this->societes[] = $societe;
            $societe->setIdTypeSociete($this);
        }

        return $this;
    }

    public function removeSociete(Societe $societe): self
    {
        if ($this->societes->contains($societe)) {
            $this->societes->removeElement($societe);
            // set the owning side to null (unless already changed)
            if ($societe->getIdTypeSociete() === $this) {
                $societe->setIdTypeSociete(null);
            }
        }

        return $this;
    }
}
