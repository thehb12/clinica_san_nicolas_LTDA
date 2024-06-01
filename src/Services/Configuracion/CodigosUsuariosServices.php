<?php

namespace App\Services\Configuracion;

use App\Entity\User;
use App\Repository\CiudadesRepository;
use App\Repository\CodigoUsuarioRepository;
use App\Repository\PaisesRepository;
use App\Repository\RegionesRepository;
use App\Repository\UserRepository;
use App\Services\MessagesServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CodigosUsuariosServices extends AbstractController
{

    private UserRepository $userRepository;
    private MessagesServices $messagesServices;

    private CodigoUsuarioRepository $codigoUsuarioRepository;

    public function __construct(
        UserRepository              $userRepository,
        MessagesServices            $messagesServices,
        CodigoUsuarioRepository $codigoUsuarioRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->messagesServices = $messagesServices;
        $this->codigoUsuarioRepository = $codigoUsuarioRepository;
    }


    public function page(): array
    {
        return $this->codigoUsuarioRepository->pagecrud($this->getUser());
    }

}