<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EcritureRepository")
 */
class Ecriture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Societe", inversedBy="ecritures")
     */
    private $idSociete;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Exercice", inversedBy="ecritures" )
     */
    private $idExercice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Journal", inversedBy="ecritures" )
     */
    private $idJournal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tokenEcriture;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $imgName="defaut_image.gif";

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $libelle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroCompte;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $debit;

    /**
     * @ORM\Column(type="float" , nullable=true)
     */
    private $credit;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        return $this->id = $id;
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

    public function getIdExercice(): ?Exercice
    {
        return $this->idExercice;
    }

    public function setIdExercice(?Exercice $idExercice): self
    {
        $this->idExercice = $idExercice;

        return $this;
    }

    public function getIdJournal(): ?Journal
    {
        return $this->idJournal;
    }

    public function setIdJournal(?Journal $idJournal): self
    {
        $this->idJournal = $idJournal;

        return $this;
    }

    public function getTokenEcriture(): ?string
    {
        return $this->tokenEcriture;
    }

    public function setTokenEcriture(string $tokenEcriture): self
    {
        $this->tokenEcriture = $tokenEcriture;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNumeroCompte(): ?string
    {
        return $this->numeroCompte;
    }

    public function setNumeroCompte(string $numeroCompte): self
    {
        $this->numeroCompte = $numeroCompte;

        return $this;
    }

    public function getDebit(): ?float
    {
        return $this->debit;
    }

    public function setDebit(?float $debit): self
    {
        $this->debit = $debit;

        return $this;
    }

    public function getCredit(): ?float
    {
        return $this->credit;
    }

    public function setCredit(float $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getImgName(): ?string
    {
        return $this->imgName;
    }

    public function setImgName(string $imgName): self
    {
        $this->imgName = $imgName;

        return $this;
    }

}
