<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\InterventoRepository")
 */
class Intervento
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
    private $numeroIntervento;

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
    private $isPersona2;

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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipoServizio;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $IndirizzoInterventoVia;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $IndirizzoInterventoComune;

    /**
     * @ORM\Column(type="integer")
     */
    private $codiceUscita;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $data1;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $data2;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $data3;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $data4;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $data5;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $data6;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codiceTrasporto;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $psDestinazione;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cognomePaziente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomePaziente;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $dataNascita;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indirizzoPazienteVia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indirizzoPazienteComune;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nazionalita;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCompletato;

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

    public function getNumeroIntervento(): ?int
    {
        return $this->numeroIntervento;
    }

    public function setNumeroIntervento(int $numeroIntervento): self
    {
        $this->numeroIntervento = $numeroIntervento;

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

    public function getIsPersona2(): ?int
    {
        return $this->isPersona2;
    }

    public function setIsPersona2(int $isPersona2): self
    {
        $this->isPersona2 = $isPersona2;

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

    public function getTipoServizio(): ?string
    {
        return $this->tipoServizio;
    }

    public function setTipoServizio(string $tipoServizio): self
    {
        $this->tipoServizio = $tipoServizio;

        return $this;
    }

    public function getIndirizzoInterventoVia(): ?string
    {
        return $this->IndirizzoInterventoVia;
    }

    public function setIndirizzoInterventoVia(?string $IndirizzoInterventoVia): self
    {
        $this->IndirizzoInterventoVia = $IndirizzoInterventoVia;

        return $this;
    }

    public function getIndirizzoInterventoComune(): ?string
    {
        return $this->IndirizzoInterventoComune;
    }

    public function setIndirizzoInterventoComune(?string $IndirizzoInterventoComune): self
    {
        $this->IndirizzoInterventoComune = $IndirizzoInterventoComune;

        return $this;
    }

    public function getCodiceUscita(): ?int
    {
        return $this->codiceUscita;
    }

    public function setCodiceUscita(int $codiceUscita): self
    {
        $this->codiceUscita = $codiceUscita;

        return $this;
    }

    public function getData1(): ?\DateTimeInterface
    {
        return $this->data1;
    }

    public function setData1(?\DateTimeInterface $data1): self
    {
        $this->data1 = $data1;

        return $this;
    }

    public function getData2(): ?\DateTimeInterface
    {
        return $this->data2;
    }

    public function setData2(?\DateTimeInterface $data2): self
    {
        $this->data2 = $data2;

        return $this;
    }

    public function getData3(): ?\DateTimeInterface
    {
        return $this->data3;
    }

    public function setData3(?\DateTimeInterface $data3): self
    {
        $this->data3 = $data3;

        return $this;
    }

    public function getData4(): ?\DateTimeInterface
    {
        return $this->data4;
    }

    public function setData4(?\DateTimeInterface $data4): self
    {
        $this->data4 = $data4;

        return $this;
    }

    public function getData5(): ?\DateTimeInterface
    {
        return $this->data5;
    }

    public function setData5(?\DateTimeInterface $data5): self
    {
        $this->data5 = $data5;

        return $this;
    }

    public function getData6(): ?\DateTimeInterface
    {
        return $this->data6;
    }

    public function setData6(?\DateTimeInterface $data6): self
    {
        $this->data6 = $data6;

        return $this;
    }

    public function getCodiceTrasporto(): ?int
    {
        return $this->codiceTrasporto;
    }

    public function setCodiceTrasporto(?int $codiceTrasporto): self
    {
        $this->codiceTrasporto = $codiceTrasporto;

        return $this;
    }

    public function getPsDestinazione(): ?string
    {
        return $this->psDestinazione;
    }

    public function setPsDestinazione(?string $psDestinazione): self
    {
        $this->psDestinazione = $psDestinazione;

        return $this;
    }

    public function getCognomePaziente(): ?string
    {
        return $this->cognomePaziente;
    }

    public function setCognomePaziente(?string $cognomePaziente): self
    {
        $this->cognomePaziente = $cognomePaziente;

        return $this;
    }

    public function getNomePaziente(): ?string
    {
        return $this->nomePaziente;
    }

    public function setNomePaziente(?string $nomePaziente): self
    {
        $this->nomePaziente = $nomePaziente;

        return $this;
    }

    public function getDataNascita(): ?\DateTimeInterface
    {
        return $this->dataNascita;
    }

    public function setDataNascita(?\DateTimeInterface $dataNascita): self
    {
        $this->dataNascita = $dataNascita;

        return $this;
    }

    public function getIndirizzoPazienteVia(): ?string
    {
        return $this->indirizzoPazienteVia;
    }

    public function setIndirizzoPazienteVia(?string $indirizzoPazienteVia): self
    {
        $this->indirizzoPazienteVia = $indirizzoPazienteVia;

        return $this;
    }

    public function getIndirizzoPazienteComune(): ?string
    {
        return $this->indirizzoPazienteComune;
    }

    public function setIndirizzoPazienteComune(?string $indirizzoPazienteComune): self
    {
        $this->indirizzoPazienteComune = $indirizzoPazienteComune;

        return $this;
    }

    public function getNazionalita(): ?string
    {
        return $this->nazionalita;
    }

    public function setNazionalita(?string $nazionalita): self
    {
        $this->nazionalita = $nazionalita;

        return $this;
    }

    public function getIsCompletato(): ?bool
    {
        return $this->isCompletato;
    }

    public function setIsCompletato(bool $isCompletato): self
    {
        $this->isCompletato = $isCompletato;

        return $this;
    }
}
