<?php

namespace App\Entity;

use App\Repository\FotosTrabajadorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FotosTrabajadorRepository::class)]
class FotosTrabajador
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $perfil = null;

    #[ORM\Column(length: 255)]
    private ?string $formulario = null;

    #[ORM\Column(length: 255)]
    private ?string $lista = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPerfil(): ?string
    {
        return $this->perfil;
    }

    public function getFormulario(): ?string
    {
        return $this->formulario;
    }


    public function getLista(): ?string
    {
        return $this->lista;
    }


    public function getPath(): ?string
    {
        return $this->path;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
        $this->configurarFotos();
    }

    private function configurarFotos(): void
    {
        $this->perfil = " <img src='/uploads/fotos/".$this->name."' alt='' width='30px' height='40px'>";
        $this->formulario = " <img src='/uploads/fotos/".$this->name."' alt='' width='30px' height='40px'>";
        $this->lista = " <img src='/uploads/fotos/".$this->name."' alt='' width='30px' height='40px'>";
        $this->path = "/uploads/fotos/".$this->name;

    }

    public function getPathChat(): string
    {
        if($this->path === null){
            return '/uploads/fotos/perfil.png';
        }
        return $this->path;
    }
}
