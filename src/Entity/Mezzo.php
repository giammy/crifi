<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MezzoRepository")
 */
class Mezzo
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
    private $targa;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $codice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sigla;

    /**
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $altro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarga(): ?string
    {
        return $this->targa;
    }

    public function setTarga(string $targa): self
    {
        $this->targa = $targa;

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

    public function getSigla(): ?string
    {
        return $this->sigla;
    }

    public function setSigla(string $sigla): self
    {
        $this->sigla = $sigla;

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
