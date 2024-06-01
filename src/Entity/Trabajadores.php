<?php

namespace App\Entity;

use App\Other\ActualizarActiveTrait;
use App\Other\UsuarioActiveTrait;
use App\Repository\TrabajadoresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrabajadoresRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Trabajadores
{
    use ActualizarActiveTrait, UsuarioActiveTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180,nullable: true)]
    private ?string $nombres = null;

    #[ORM\Column(length: 180,nullable: true)]
    private ?string $direccion = null;

    #[ORM\Column(type: Types::BIGINT,nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(length: 180,nullable: true)]
    private ?string $tipo = null;
    #[ORM\Column(length: 180,nullable: true)]
    private ?string $numeroId = null;

    #[ORM\Column(length: 180,nullable: true)]
    private ?string $lugarExpedicion = null;

    #[ORM\Column(length: 180,nullable: true)]
    private ?string $cargo = null;

    #[ORM\Column(nullable: true)]
    private \DateTime $fechaInicial;

    #[ORM\Column(nullable: true)]
    private \DateTime $fechaFinal;

    #[ORM\Column(nullable: true)]
    private ?float $saldo = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $auxt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?FotosTrabajador $fotoTrabajadores = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(?string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(?string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

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


    public function getNumeroId(): ?string
    {
        return $this->numeroId;
    }

    public function setNumeroId(?string $numeroId): self
    {
        $this->numeroId = $numeroId;

        return $this;
    }

    public function getLugarExpedicion(): ?string
    {
        return $this->lugarExpedicion;
    }

    public function setLugarExpedicion(?string $lugarExpedicion): self
    {
        $this->lugarExpedicion = $lugarExpedicion;

        return $this;
    }

    public function getCargo(): ?string
    {
        return $this->cargo;
    }

    public function setCargo(?string $cargo): self
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function getFechaInicial(): \DateTime
    {
        return $this->fechaInicial;
    }

    public function setFechaInicial(\DateTime $fechaInicial): self
    {
        $this->fechaInicial = $fechaInicial;

        return $this;
    }

    public function getFechaFinal(): \DateTime
    {
        return $this->fechaFinal;
    }

    public function setFechaFinal(\DateTime $fechaFinal): self
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    public function getSaldo(): ?float
    {
        return $this->saldo;
    }

    public function setSaldo(?float $saldo): self
    {
        $this->saldo = $saldo;

        return $this;
    }

    public function getAuxt(): ?string
    {
        return $this->auxt;
    }

    public function setAuxt(?string $auxt): self
    {
        $this->auxt = $auxt;

        return $this;
    }

    public function getFoto(): ?string
    {

        if( $this->foto == ""){
            return "uploads/default/perfil_default.png";
        }
        return "uploads/fotos/".$this->foto;
    }

    public function setFoto(?string $foto): void
    {
        $this->foto = $foto;
    }

    public function getFotoTrabajadores(): ?FotosTrabajador
    {
        return $this->fotoTrabajadores;
    }

    public function setFotoTrabajadores(?FotosTrabajador $fotoTrabajadores): self
    {
        $this->fotoTrabajadores = $fotoTrabajadores;
return $this;
    }


}
