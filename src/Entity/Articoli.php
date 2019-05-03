<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticoliRepository")
 */
class Articoli
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
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateadd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_avaiable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codice;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descrizione;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $dotazioni;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $danni;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastuser;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastmovement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motivation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDateadd(): ?\DateTimeInterface
    {
        return $this->dateadd;
    }

    public function setDateadd(\DateTimeInterface $dateadd): self
    {
        $this->dateadd = $dateadd;

        return $this;
    }

    public function getIsAvaiable(): ?bool
    {
        return $this->is_avaiable;
    }

    public function setIsAvaiable(bool $is_avaiable): self
    {
        $this->is_avaiable = $is_avaiable;

        return $this;
    }

    public function getCodice(): ?string
    {
        return $this->codice;
    }

    public function setCodice(string $codice): self
    {
        $this->codice = $codice;

        return $this;
    }

    public function getDescrizione(): ?string
    {
        return $this->descrizione;
    }

    public function setDescrizione(?string $descrizione): self
    {
        $this->descrizione = $descrizione;

        return $this;
    }

    public function getDotazioni(): ?string
    {
        return $this->dotazioni;
    }

    public function setDotazioni(?string $dotazioni): self
    {
        $this->dotazioni = $dotazioni;

        return $this;
    }

    public function getDanni(): ?string
    {
        return $this->danni;
    }

    public function setDanni(?string $danni): self
    {
        $this->danni = $danni;

        return $this;
    }

    public function getLastuser(): ?string
    {
        return $this->lastuser;
    }

    public function setLastuser(?string $lastuser): self
    {
        $this->lastuser = $lastuser;

        return $this;
    }

    public function getLastmovement(): ?\DateTimeInterface
    {
        return $this->lastmovement;
    }

    public function setLastmovement(?\DateTimeInterface $lastmovement): self
    {
        $this->lastmovement = $lastmovement;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(?string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
