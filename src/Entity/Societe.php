<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SocieteRepository")
 */
class Societe
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
    private $tokenSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NumeroInterneSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RaisonSocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $AdresseSociete;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $CodePostalSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Pays;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $TelSociete;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $MobileSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $EmailSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SIRETSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $RCSociete;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $NumTVASociete;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreationSociete;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File
     */
    private $logoSociete;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="societes", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="societe_utilisateur")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Banque", mappedBy="societe")
     */
    private $banques;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Droit", mappedBy="Societe")
     */
    private $droits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur")
     */
    private $idUtilisateurGerant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeSociete", inversedBy="societes")
     */
    private $idTypeSociete;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSocietePrincipale;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ecriture", mappedBy="idSociete", orphanRemoval=true)
     */
    private $ecritures;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Exercice", mappedBy="idSociete")
     */
    private $exercices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Journal", mappedBy="idSociete")
     */
    private $journals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="idSociete")
     */
    private $clients;


    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->banques = new ArrayCollection();
        $this->droits = new ArrayCollection();
        $this->ecritures = new ArrayCollection();
        $this->exercices = new ArrayCollection();
        $this->journals = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getTokenSociete(): ?string
    {
        return $this->tokenSociete;
    }

    public function setTokenSociete(string $tokenSociete): self
    {
        $this->tokenSociete = $tokenSociete;

        return $this;
    }

    public function getNumeroInterneSociete(): ?string
    {
        return $this->NumeroInterneSociete;
    }

    public function setNumeroInterneSociete(?string $NumeroInterneSociete): self
    {
        $this->NumeroInterneSociete = $NumeroInterneSociete;

        return $this;
    }

    public function getRaisonSocial(): ?string
    {
        return $this->RaisonSocial;
    }

    public function setRaisonSocial(?string $RaisonSocial): self
    {
        $this->RaisonSocial = $RaisonSocial;

        return $this;
    }

    public function getAdresseSociete(): ?string
    {
        return $this->AdresseSociete;
    }

    public function setAdresseSociete(?string $AdresseSociete): self
    {
        $this->AdresseSociete = $AdresseSociete;

        return $this;
    }

    public function getCodePostalSociete(): ?string
    {
        return $this->CodePostalSociete;
    }

    public function setCodePostalSociete(?string $CodePostalSociete): self
    {
        $this->CodePostalSociete = $CodePostalSociete;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(?string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(?string $Pays): self
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getTelSociete(): ?string
    {
        return $this->TelSociete;
    }

    public function setTelSociete(?string $TelSociete): self
    {
        $this->TelSociete = $TelSociete;

        return $this;
    }

    public function getMobileSociete(): ?string
    {
        return $this->MobileSociete;
    }

    public function setMobileSociete(?string $MobileSociete): self
    {
        $this->MobileSociete = $MobileSociete;

        return $this;
    }

    public function getEmailSociete(): ?string
    {
        return $this->EmailSociete;
    }

    public function setEmailSociete(?string $EmailSociete): self
    {
        $this->EmailSociete = $EmailSociete;

        return $this;
    }

    public function getSIRETSociete(): ?string
    {
        return $this->SIRETSociete;
    }

    public function setSIRETSociete(?string $SIRETSociete): self
    {
        $this->SIRETSociete = $SIRETSociete;

        return $this;
    }

    public function getRCSociete(): ?string
    {
        return $this->RCSociete;
    }

    public function setRCSociete(?string $RCSociete): self
    {
        $this->RCSociete = $RCSociete;

        return $this;
    }

    public function getNumTVASociete(): ?string
    {
        return $this->NumTVASociete;
    }

    public function setNumTVASociete(?string $NumTVASociete): self
    {
        $this->NumTVASociete = $NumTVASociete;

        return $this;
    }

    public function getDateCreationSociete(): ?\DateTimeInterface
    {
        return $this->dateCreationSociete;
    }

    public function setDateCreationSociete(\DateTimeInterface $dateCreationSociete): self
    {
        $this->dateCreationSociete = $dateCreationSociete;

        return $this;
    }

    public function getLogoSociete()
    {
        return $this->logoSociete;
    }

    public function setLogoSociete($logoSociete)
    {
        $this->logoSociete = $logoSociete;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
        }

        return $this;
    }

    /**
     * @return Collection|Banque[]
     */
    public function getBanques(): Collection
    {
        return $this->banques;
    }

    public function addBanque(Banque $banque): self
    {
        if (!$this->banques->contains($banque)) {
            $this->banques[] = $banque;
            $banque->setSociete($this);
        }

        return $this;
    }

    public function removeBanque(Banque $banque): self
    {
        if ($this->banques->contains($banque)) {
            $this->banques->removeElement($banque);
            // set the owning side to null (unless already changed)
            if ($banque->getSociete() === $this) {
                $banque->setSociete(null);
            }
        }

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
            $droit->setSociete($this);
        }

        return $this;
    }

    public function removeDroit(Droit $droit): self
    {
        if ($this->droits->contains($droit)) {
            $this->droits->removeElement($droit);
            // set the owning side to null (unless already changed)
            if ($droit->getSociete() === $this) {
                $droit->setSociete(null);
            }
        }

        return $this;
    }

    public function getIdUtilisateurGerant(): ?Utilisateur
    {
        return $this->idUtilisateurGerant;
    }

    public function setIdUtilisateurGerant(?Utilisateur $idUtilisateurGerant): self
    {
        $this->idUtilisateurGerant = $idUtilisateurGerant;

        return $this;
    }

    public function getIdTypeSociete(): ?TypeSociete
    {
        return $this->idTypeSociete;
    }

    public function setIdTypeSociete(?TypeSociete $idTypeSociete): self
    {
        $this->idTypeSociete = $idTypeSociete;

        return $this;
    }

    public function getIsSocietePrincipale(): ?bool
    {
        return $this->isSocietePrincipale;
    }

    public function setIsSocietePrincipale(?bool $isSocietePrincipale): self
    {
        $this->isSocietePrincipale = $isSocietePrincipale;

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
            $ecriture->setIdSociete($this);
        }

        return $this;
    }

    public function removeEcriture(Ecriture $ecriture): self
    {
        if ($this->ecritures->contains($ecriture)) {
            $this->ecritures->removeElement($ecriture);
            // set the owning side to null (unless already changed)
            if ($ecriture->getIdSociete() === $this) {
                $ecriture->setIdSociete(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Exercice[]
     */
    public function getExercices(): Collection
    {
        return $this->exercices;
    }

    public function addExercice(Exercice $exercice): self
    {
        if (!$this->exercices->contains($exercice)) {
            $this->exercices[] = $exercice;
            $exercice->setIdSociete($this);
        }

        return $this;
    }

    public function removeExercice(Exercice $exercice): self
    {
        if ($this->exercices->contains($exercice)) {
            $this->exercices->removeElement($exercice);
            // set the owning side to null (unless already changed)
            if ($exercice->getIdSociete() === $this) {
                $exercice->setIdSociete(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Journal[]
     */
    public function getJournals(): Collection
    {
        return $this->journals;
    }

    public function addJournal(Journal $journal): self
    {
        if (!$this->journals->contains($journal)) {
            $this->journals[] = $journal;
            $journal->setIdSociete($this);
        }

        return $this;
    }

    public function removeJournal(Journal $journal): self
    {
        if ($this->journals->contains($journal)) {
            $this->journals->removeElement($journal);
            // set the owning side to null (unless already changed)
            if ($journal->getIdSociete() === $this) {
                $journal->setIdSociete(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setIdSociete($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getIdSociete() === $this) {
                $client->setIdSociete(null);
            }
        }

        return $this;
    }


}
