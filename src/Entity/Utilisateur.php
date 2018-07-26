<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields="loginUtilisateur")
 */



class Utilisateur  implements UserInterface, \Serializable 
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
    private $tokenUtilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Civilite")
     */
    private $idCivilite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NomUtilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $PrenomUtilisateur;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $TelUtilisateur;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $MobileUtilisateur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $EmailUtilisateur;

     /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\File
     */
    private $urlPhoto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $loginUtilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdpUtilisateur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscriptionUtilisateur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActiveUtilisateur;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isExpertComptable;


    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Societe", mappedBy="utilisateurs")
     */
    private $societes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Droit", mappedBy="utilisateur")
     */
    private $droits;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idParent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="idUtilisateur")
     */
    private $clients;

    public function __construct()
    {
        $this->societes = new ArrayCollection();
        $this->droits = new ArrayCollection();
        $this->clients = new ArrayCollection();
    }

    

    public function getUsername() {
        return $this->loginUtilisateur;
    }

    public function getSalt() {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword() {
        return $this->mdpUtilisateur;
    }

    function setPassword($password) {
        $this->mdpUtilisateur = $password;
    }

     public function getRoles() {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }
        return $this->roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    function addRole($role) {
        $this->roles[] = $role;
    }

    public function eraseCredentials() {
       
    }

    /** @see \Serializable::serialize() */
    public function serialize() {
        return serialize(array(
            $this->id,
            $this->loginUtilisateur,
            $this->mdpUtilisateur,
            $this->isActiveUtilisateur,
                // see section on salt below
                // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized) {
        list (
                $this->id,
                $this->loginUtilisateur,
                $this->mdpUtilisateur,
                $this->isActiveUtilisateur,
                // see section on salt below
                // $this->salt
                ) = unserialize($serialized);
    }



    public function getId()
    {
        return $this->id;
    }

    public function getTokenUtilisateur(): ?string
    {
        return $this->tokenUtilisateur;
    }

    public function setTokenUtilisateur(string $tokenUtilisateur): self
    {
        $this->tokenUtilisateur = $tokenUtilisateur;

        return $this;
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

    public function getNomUtilisateur(): ?string
    {
        return $this->NomUtilisateur;
    }

    public function setNomUtilisateur(string $NomUtilisateur): self
    {
        $this->NomUtilisateur = $NomUtilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->PrenomUtilisateur;
    }

    public function setPrenomUtilisateur(?string $PrenomUtilisateur): self
    {
        $this->PrenomUtilisateur = $PrenomUtilisateur;

        return $this;
    }

    public function getTelUtilisateur(): ?string
    {
        return $this->TelUtilisateur;
    }

    public function setTelUtilisateur(?string $TelUtilisateur): self
    {
        $this->TelUtilisateur = $TelUtilisateur;

        return $this;
    }

    public function getMobileUtilisateur(): ?string
    {
        return $this->MobileUtilisateur;
    }

    public function setMobileUtilisateur(?string $MobileUtilisateur): self
    {
        $this->MobileUtilisateur = $MobileUtilisateur;

        return $this;
    }

    public function getUrlPhoto()
    {
        return $this->urlPhoto;
    }

    public function setUrlPhoto($urlPhoto)
    {
        $this->urlPhoto = $urlPhoto;

        return $this;
    }

    public function getEmailUtilisateur(): ?string
    {
        return $this->EmailUtilisateur;
    }

    public function setEmailUtilisateur(?string $EmailUtilisateur): self
    {
        $this->EmailUtilisateur = $EmailUtilisateur;

        return $this;
    }

    public function getLoginUtilisateur(): ?string
    {
        return $this->loginUtilisateur;
    }

    public function setLoginUtilisateur(string $loginUtilisateur): self
    {
        $this->loginUtilisateur = $loginUtilisateur;

        return $this;
    }

    public function getMdpUtilisateur(): ?string
    {
        return $this->mdpUtilisateur;
    }

    public function setMdpUtilisateur(string $mdpUtilisateur): self
    {
        $this->mdpUtilisateur = $mdpUtilisateur;

        return $this;
    }

    public function getDateInscriptionUtilisateur(): ?\DateTimeInterface
    {
        return $this->dateInscriptionUtilisateur;
    }

    public function setDateInscriptionUtilisateur(\DateTimeInterface $dateInscriptionUtilisateur): self
    {
        $this->dateInscriptionUtilisateur = $dateInscriptionUtilisateur;

        return $this;
    }

    public function getIsActiveUtilisateur(): ?bool
    {
        return $this->isActiveUtilisateur;
    }

    public function setIsActiveUtilisateur(bool $isActiveUtilisateur): self
    {
        $this->isActiveUtilisateur = $isActiveUtilisateur;

        return $this;
    }

    public function getIsExpertComptable(): ?bool
    {
        return $this->isExpertComptable;
    }

    public function setIsExpertComptable(bool $isExpertComptable): self
    {
        $this->isExpertComptable = $isExpertComptable;

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
            $societe->addUtilisateur($this);
        }

        return $this;
    }

    public function removeSociete(Societe $societe): self
    {
        if ($this->societes->contains($societe)) {
            $this->societes->removeElement($societe);
            $societe->removeUtilisateur($this);
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
            $droit->setUtilisateur($this);
        }

        return $this;
    }

    public function removeDroit(Droit $droit): self
    {
        if ($this->droits->contains($droit)) {
            $this->droits->removeElement($droit);
            // set the owning side to null (unless already changed)
            if ($droit->getUtilisateur() === $this) {
                $droit->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getIdParent(): ?int
    {
        return $this->idParent;
    }

    public function setIdParent(?int $idParent): self
    {
        $this->idParent = $idParent;

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
            $client->setIdUtilisateur($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getIdUtilisateur() === $this) {
                $client->setIdUtilisateur(null);
            }
        }

        return $this;
    }
}
