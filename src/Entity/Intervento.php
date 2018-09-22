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
    private $kmPartenza;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $kmArrivo;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroTurno;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroIntervento;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numeroInterventoBis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipoServizio;

    /**
     * @ORM\Column(type="json")
     */
    private $idPersonaABCTLista = [];

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $indirizzoInterventoVia;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $indirizzoInterventoComune;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codiceUscita;

    /**
     * @ORM\Column(type="json")
     */
    private $dateLista = [];


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $codiceTrasporto;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $psDestinazione;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAnonimoPaziente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cognomePaziente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomePaziente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $codiceFiscalePaziente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sessoPaziente;


    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $dataNascitaPaziente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indirizzoViaPaziente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indirizzoComunePaziente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nazionalitaPaziente;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCompletato;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isStampato;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $note;

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

    public function getKmPartenza(): ?int
    {
        return $this->kmPartenza;
    }

    public function setKmPartenza(int $kmPartenza): self
    {
        $this->kmPartenza = $kmPartenza;

        return $this;
    }

    public function getKmArrivo(): ?int
    {
        return $this->kmArrivo;
    }

    public function setKmArrivo(?int $kmArrivo): self
    {
        $this->kmArrivo = $kmArrivo;

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

    public function getNumeroInterventoBis(): ?string
    {
        return $this->numeroInterventoBis;
    }

    public function setNumeroInterventoBis(?string $numeroInterventoBis): self
    {
        $this->numeroInterventoBis = $numeroInterventoBis;

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

    public function getIdPersonaABCTLista(): ?array
    {
        return $this->idPersonaABCTLista;
    }

    public function setIdPersonaABCTLista(array $idPersonaABCTLista): self
    {
        $this->idPersonaABCTLista = $idPersonaABCTLista;

        return $this;
    }

    public function getIndirizzoInterventoVia(): ?string
    {
        return $this->indirizzoInterventoVia;
    }

    public function setIndirizzoInterventoVia(?string $IndirizzoInterventoVia): self
    {
        $this->indirizzoInterventoVia = $IndirizzoInterventoVia;

        return $this;
    }

    public function getIndirizzoInterventoComune(): ?string
    {
        return $this->indirizzoInterventoComune;
    }

    public function setIndirizzoInterventoComune(?string $IndirizzoInterventoComune): self
    {
        $this->indirizzoInterventoComune = $IndirizzoInterventoComune;

        return $this;
    }

    public function getCodiceUscita(): ?int
    {
        return $this->codiceUscita;
    }

    public function setCodiceUscita(?int $codiceUscita): self
    {
        $this->codiceUscita = $codiceUscita;

        return $this;
    }

    public function getDateLista(): ?array
    {
        return $this->dateLista;
    }

    public function setDateLista(array $dateLista): self
    {
        $this->dateLista = $dateLista;

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

    public function getIsAnonimoPaziente(): ?bool
    {
        return $this->isAnonimoPaziente;
    }

    public function setIsAnonimoPaziente(bool $isAnonimoPaziente): self
    {
        $this->isAnonimoPaziente = $isAnonimoPaziente;

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

    public function getCodiceFiscalePaziente(): ?string
    {
        return $this->codiceFiscalePaziente;
    }

    public function setCodiceFiscalePaziente(?string $codiceFiscalePaziente): self
    {
        $this->codiceFiscalePaziente = $codiceFiscalePaziente;

        return $this;
    }

    public function getSessoPaziente(): ?string
    {
        return $this->sessoPaziente;
    }

    public function setSessoPaziente(?string $sessoPaziente): self
    {
        $this->sessoPaziente = $sessoPaziente;

        return $this;
    }

    public function getDataNascitaPaziente(): ?\DateTimeInterface
    {
        return $this->dataNascitaPaziente;
    }

    public function setDataNascitaPaziente(?\DateTimeInterface $dataNascitaPaziente): self
    {
        $this->dataNascitaPaziente = $dataNascitaPaziente;

        return $this;
    }

    public function getIndirizzoViaPaziente(): ?string
    {
        return $this->indirizzoViaPaziente;
    }

    public function setIndirizzoViaPaziente(?string $indirizzoViaPaziente): self
    {
        $this->indirizzoViaPaziente = $indirizzoViaPaziente;

        return $this;
    }

    public function getIndirizzoComunePaziente(): ?string
    {
        return $this->indirizzoComunePaziente;
    }

    public function setIndirizzoComunePaziente(?string $indirizzoComunePaziente): self
    {
        $this->indirizzoComunePaziente = $indirizzoComunePaziente;

        return $this;
    }

    public function getNazionalitaPaziente(): ?string
    {
        return $this->nazionalitaPaziente;
    }

    public function setNazionalitaPaziente(?string $nazionalitaPaziente): self
    {
        $this->nazionalitaPaziente = $nazionalitaPaziente;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getIsStampato(): ?bool
    {
        return $this->isStampato;
    }

    public function setIsStampato(bool $isStampato): self
    {
        $this->isStampato = $isStampato;

        return $this;
    }

}
