<?php

namespace App\Services\Configuracion;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordServices
{

    private string $oldPass;
    private string $newPass;
    private string $repeatPass;


    private ?User $user;

    private UserPasswordHasherInterface $passwordHasher;
    private UserRepository $repository;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        UserRepository              $repository
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->repository = $repository;
    }


    public function isFromIncompleto(): bool
    {
        return ($this->oldPass === "" || $this->newPass === "" || $this->repeatPass === "");
    }


    public function isPassOldValido(): bool
    {
        return $this->passwordHasher->isPasswordValid($this->user, $this->oldPass);
    }

    public function isPassNoSonIguales(): bool
    {
        return ($this->newPass != $this->repeatPass);
    }

    public function cambiarPassword(): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
            $this->user,
            $this->newPass
        );
        $this->user->setPassword($hashedPassword);
        $this->repository->guardar($this->user);
    }


    public function setOldPass(string $oldPass): void
    {
        $this->oldPass = $oldPass;
    }


    public function setNewPass(string $newPass): void
    {
        $this->newPass = $newPass;
    }

    public function setRepeatPass(string $repeatPass): void
    {
        $this->repeatPass = $repeatPass;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }


}