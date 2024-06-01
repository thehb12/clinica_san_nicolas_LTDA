<?php

namespace App\Other;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

trait UsuarioActiveTrait
{
    #[ORM\ManyToOne]
    private ?User $usuCreate = null;

    #[ORM\ManyToOne]
    private ?User $usuUpdate = null;

    public function getUsuCreate(): ?User
    {
        return $this->usuCreate;
    }

    public function setUsuCreate(?User $usuCreate):self
    {
        $this->usuCreate = $usuCreate;

        return $this;
    }

    public function getUsuUpdate(): ?User
    {
        return $this->usuUpdate;
    }

    public function setUsuUpdate(?User $usuUpdate): self
    {
        $this->usuUpdate = $usuUpdate;

        return $this;
    }



}