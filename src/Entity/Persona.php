<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PersonaRepository")
 */
class Persona
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
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cognome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codiceFiscale;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codiceCRI;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $altro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getCognome(): ?string
    {
        return $this->cognome;
    }

    public function setCognome(string $cognome): self
    {
        $this->cognome = $cognome;

        return $this;
    }

    public function getCodiceFiscale(): ?string
    {
        return $this->codiceFiscale;
    }

    public function setCodiceFiscale(string $codiceFiscale): self
    {
        $this->codiceFiscale = $codiceFiscale;

        return $this;
    }

    public function getCodiceCRI(): ?string
    {
        return $this->codiceCRI;
    }

    public function setCodiceCRI(string $codiceCRI): self
    {
        $this->codiceCRI = $codiceCRI;

        return $this;
    }

    public function getAltro(): ?string
    {
        return $this->altro;
    }

    public function setAltro(?string $altro): self
    {
        $this->altro = $altro;

        return $this;
    }
}
