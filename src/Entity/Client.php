<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Civilite", inversedBy="clients")
     */
    private $idCivilite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomClient;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $adresseClient;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codePostalClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $villeClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paysClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $telClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siretClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mobileClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $emailClient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroTvaClient;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notesClient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="clients")
     */
    private $idUtilisateur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActiveClient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Societe", inversedBy="clients")
     */
    private $idSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tokenClient;

    public function getId()
    {
        return $this->id;
    }

    public function getIdCivilite(): ?Civilite
    {
        return $this->idCivilite;
    }

    public function setIdCivilite(?Civilite $idCivilite): self
    {
        $this->idCivilite = $idCivilite;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(?string $nomClient): self
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getPrenomClient(): ?string
    {
        return $this->prenomClient;
    }

    public function setPrenomClient(?string $prenomClient): self
    {
        $this->prenomClient = $prenomClient;

        return $this;
    }

    public function getAdresseClient(): ?string
    {
        return $this->adresseClient;
    }

    public function setAdresseClient(?string $adresseClient): self
    {
        $this->adresseClient = $adresseClient;

        return $this;
    }

    public function getCodePostalClient(): ?string
    {
        return $this->codePostalClient;
    }

    public function setCodePostalClient(?string $codePostalClient): self
    {
        $this->codePostalClient = $codePostalClient;

        return $this;
    }

    public function getVilleClient(): ?string
    {
        return $this->villeClient;
    }

    public function setVilleClient(?string $villeClient): self
    {
        $this->villeClient = $villeClient;

        return $this;
    }

    public function getPaysClient(): ?string
    {
        return $this->paysClient;
    }

    public function setPaysClient(?string $paysClient): self
    {
        $this->paysClient = $paysClient;

        return $this;
    }

    public function getTelClient(): ?string
    {
        return $this->telClient;
    }

    public function setTelClient(?string $telClient): self
    {
        $this->telClient = $telClient;

        return $this;
    }

    public function getSiretClient(): ?string
    {
        return $this->siretClient;
    }

    public function setSiretClient(?string $siretClient): self
    {
        $this->siretClient = $siretClient;

        return $this;
    }

    public function getMobileClient(): ?string
    {
        return $this->mobileClient;
    }

    public function setMobileClient(?string $mobileClient): self
    {
        $this->mobileClient = $mobileClient;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->emailClient;
    }

    public function setEmailClient(?string $emailClient): self
    {
        $this->emailClient = $emailClient;

        return $this;
    }

    public function getNumeroTvaClient(): ?string
    {
        return $this->numeroTvaClient;
    }

    public function setNumeroTvaClient(?string $numeroTvaClient): self
    {
        $this->numeroTvaClient = $numeroTvaClient;

        return $this;
    }

    public function getNotesClient(): ?string
    {
        return $this->notesClient;
    }

    public function setNotesClient(?string $notesClient): self
    {
        $this->notesClient = $notesClient;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getIsActiveClient(): ?bool
    {
        return $this->isActiveClient;
    }

    public function setIsActiveClient(?bool $isActiveClient): self
    {
        $this->isActiveClient = $isActiveClient;

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

    public function getTokenClient(): ?string
    {
        return $this->tokenClient;
    }

    public function setTokenClient(?string $tokenClient): self
    {
        $this->tokenClient = $tokenClient;

        return $this;
    }
}
