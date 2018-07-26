<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DroitRepository")
 */
class Droit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="droits")
     */
    private $utilisateurId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Societe", inversedBy="droits")
     */
    private $SocieteId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lectureEcritureSuppression;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $SeulTous;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Module", inversedBy="droits")
     */
    private $moduleID;

    public function getId()
    {
        return $this->id;
    }

    public function getUtilisateurId(): ?Utilisateur
    {
        return $this->utilisateurId;
    }

    public function setUtilisateurId(?Utilisateur $utilisateurId): self
    {
        $this->utilisateurId = $utilisateurId;

        return $this;
    }

    public function getSocieteId(): ?Societe
    {
        return $this->SocieteId;
    }

    public function setSocieteId(?Societe $SocieteId): self
    {
        $this->SocieteId = $SocieteId;

        return $this;
    }

    public function getLectureEcritureSuppression(): ?int
    {
        return $this->lectureEcritureSuppression;
    }

    public function setLectureEcritureSuppression(?int $lectureEcritureSuppression): self
    {
        $this->lectureEcritureSuppression = $lectureEcritureSuppression;

        return $this;
    }

    public function getSeulTous(): ?bool
    {
        return $this->SeulTous;
    }

    public function setSeulTous(?bool $SeulTous): self
    {
        $this->SeulTous = $SeulTous;

        return $this;
    }

    public function getModuleID(): ?Module
    {
        return $this->moduleID;
    }

    public function setModuleID(?Module $moduleID): self
    {
        $this->moduleID = $moduleID;

        return $this;
    }
}
