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
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="json")
     */
    private $idPersonaABCTLista = [];

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $inizio;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $fine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tipo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $quando;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getIdPersonaABCTLista(): ?array
    {
        return $this->idPersonaABCTLista;
    }

    public function setIdPersonaABCTLista(array $idPersonaABCTLista): self
    {
        $this->idPersonaABCTLista = $idPersonaABCTLista;

        return $this;
    }

    public function getInizio(): ?\DateTimeInterface
    {
        return $this->inizio;
    }

    public function setInizio(\DateTimeInterface $inizio): self
    {
        $this->inizio = $inizio;

        return $this;
    }

    public function getFine(): ?\DateTimeInterface
    {
        return $this->fine;
    }

    public function setFine(?\DateTimeInterface $fine): self
    {
        $this->fine = $fine;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getQuando(): ?string
    {
        return $this->quando;
    }

    public function setQuando(?string $quando): self
    {
        $this->quando = $quando;

        return $this;
    }
}
