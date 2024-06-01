<?php

namespace App\Other;

use Doctrine\ORM\Mapping as ORM;

trait ActualizarActiveTrait
{

    #[ORM\Column(nullable: true)]
    private \DateTime $fechacreate;

    #[ORM\Column(nullable: true)]
    private \DateTime $fechaupdate;

    #[ORM\Column(nullable: true)]
    private int $estado = 1;

    public function getFechacreate(): ?\DateTime
    {
        return $this->fechacreate;
    }

    #[ORM\PrePersist]
    public function setFechacreate(): void
    {
        $this->fechacreate = new \DateTime();
    }

    public function getFechaupdate(): ?\DateTime
    {
        return $this->fechaupdate;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setFechaupdate(): void
    {
        $this->fechaupdate = new \DateTime();

    }

    public function getEstado(): int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): void
    {
        $this->estado = $estado;
    }

    #[ORM\PrePersist]
    public function activar(): void
    {
        $this->estado = 1;
    }

    public function desactivar(): void
    {
        $this->estado = 2;
    }

}