<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModuleRepository")
 */
class Module
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
    private $nomModule;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActiveModule;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $controllerModule;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Droit", mappedBy="moduleID")
     */
    private $droits;

    public function __construct()
    {
        $this->droits = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNomModule(): ?string
    {
        return $this->nomModule;
    }

    public function setNomModule(?string $nomModule): self
    {
        $this->nomModule = $nomModule;

        return $this;
    }

    public function getIsActiveModule(): ?bool
    {
        return $this->isActiveModule;
    }

    public function setIsActiveModule(?bool $isActiveModule): self
    {
        $this->isActiveModule = $isActiveModule;

        return $this;
    }

    public function getControllerModule(): ?string
    {
        return $this->controllerModule;
    }

    public function setControllerModule(?string $controllerModule): self
    {
        $this->controllerModule = $controllerModule;

        return $this;
    }

    /**
     * @return Collection|Droit[]
     */
    public function getDroits(): Collection
    {
        return $this->droits;
    }

    public function addDroit(Droit $droit): self
    {
        if (!$this->droits->contains($droit)) {
            $this->droits[] = $droit;
            $droit->setModuleID($this);
        }

        return $this;
    }

    public function removeDroit(Droit $droit): self
    {
        if ($this->droits->contains($droit)) {
            $this->droits->removeElement($droit);
            // set the owning side to null (unless already changed)
            if ($droit->getModuleID() === $this) {
                $droit->setModuleID(null);
            }
        }

        return $this;
    }
}
