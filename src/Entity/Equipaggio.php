<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\EquipaggioRepository")
 */
class Equipaggio
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idMezzo;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroTurno;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPersona;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPersona1;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAutista1;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCapoEquipaggio1;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPersona2;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAutista2;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCapoEquipaggio2;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPersona3;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAutista3;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCapoEquipaggio3;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idPersona4;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAutista4;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isCapoEquipaggio4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMezzo(): ?int
    {
        return $this->idMezzo;
    }

    public function setIdMezzo(int $idMezzo): self
    {
        $this->idMezzo = $idMezzo;

        return $this;
    }

    public function getNumeroTurno(): ?int
    {
        return $this->numeroTurno;
    }

    public function setNumeroTurno(int $numeroTurno): self
    {
        $this->numeroTurno = $numeroTurno;

        return $this;
    }

    public function getIdPersona(): ?int
    {
        return $this->idPersona;
    }

    public function setIdPersona(int $idPersona): self
    {
        $this->idPersona = $idPersona;

        return $this;
    }

    public function getIdPersona1(): ?int
    {
        return $this->idPersona1;
    }

    public function setIdPersona1(int $idPersona1): self
    {
        $this->idPersona1 = $idPersona1;

        return $this;
    }

    public function getIsAutista1(): ?bool
    {
        return $this->isAutista1;
    }

    public function setIsAutista1(bool $isAutista1): self
    {
        $this->isAutista1 = $isAutista1;

        return $this;
    }

    public function getIsCapoEquipaggio1(): ?bool
    {
        return $this->isCapoEquipaggio1;
    }

    public function setIsCapoEquipaggio1(bool $isCapoEquipaggio1): self
    {
        $this->isCapoEquipaggio1 = $isCapoEquipaggio1;

        return $this;
    }

    public function getIdPersona2(): ?int
    {
        return $this->idPersona2;
    }

    public function setIdPersona2(int $idPersona2): self
    {
        $this->idPersona2 = $idPersona2;

        return $this;
    }

    public function getIsAutista2(): ?bool
    {
        return $this->isAutista2;
    }

    public function setIsAutista2(bool $isAutista2): self
    {
        $this->isAutista2 = $isAutista2;

        return $this;
    }

    public function getIsCapoEquipaggio2(): ?bool
    {
        return $this->isCapoEquipaggio2;
    }

    public function setIsCapoEquipaggio2(bool $isCapoEquipaggio2): self
    {
        $this->isCapoEquipaggio2 = $isCapoEquipaggio2;

        return $this;
    }

    public function getIdPersona3(): ?int
    {
        return $this->idPersona3;
    }

    public function setIdPersona3(int $idPersona3): self
    {
        $this->idPersona3 = $idPersona3;

        return $this;
    }

    public function getIsAutista3(): ?bool
    {
        return $this->isAutista3;
    }

    public function setIsAutista3(bool $isAutista3): self
    {
        $this->isAutista3 = $isAutista3;

        return $this;
    }

    public function getIsCapoEquipaggio3(): ?bool
    {
        return $this->isCapoEquipaggio3;
    }

    public function setIsCapoEquipaggio3(bool $isCapoEquipaggio3): self
    {
        $this->isCapoEquipaggio3 = $isCapoEquipaggio3;

        return $this;
    }

    public function getIdPersona4(): ?int
    {
        return $this->idPersona4;
    }

    public function setIdPersona4(?int $idPersona4): self
    {
        $this->idPersona4 = $idPersona4;

        return $this;
    }

    public function getIsAutista4(): ?bool
    {
        return $this->isAutista4;
    }

    public function setIsAutista4(?bool $isAutista4): self
    {
        $this->isAutista4 = $isAutista4;

        return $this;
    }

    public function getIsCapoEquipaggio4(): ?bool
    {
        return $this->isCapoEquipaggio4;
    }

    public function setIsCapoEquipaggio4(?bool $isCapoEquipaggio4): self
    {
        $this->isCapoEquipaggio4 = $isCapoEquipaggio4;

        return $this;
    }
}
