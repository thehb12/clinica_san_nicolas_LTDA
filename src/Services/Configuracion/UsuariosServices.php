<?php

namespace App\Services\Configuracion;

use App\Entity\Trabajadores;
use App\Entity\User;
use App\Repository\TrabajadoresRepository;
use App\Repository\UserRepository;
use App\Services\MessagesServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuariosServices extends AbstractController
{

    private UserRepository $userRepository;
    private MessagesServices $messagesServices;
    private UserPasswordHasherInterface $passwordHasher;
    private TrabajadoresRepository $trabajadoresRepository;

    public function __construct(
        UserRepository              $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        MessagesServices            $messagesServices,
        TrabajadoresRepository $trabajadoresRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->messagesServices = $messagesServices;
        $this->trabajadoresRepository = $trabajadoresRepository;
    }


    public function page(): array
    {
        return $this->userRepository->pagecrud($this->getUser());
    }

    public function create_update(
        int    $id,
        string $nombre,
        string $correo,
        string $contrasena,
        string $confirmar_contrasena,
        ?int   $estado
    ): array
    {
        if ($confirmar_contrasena !== $contrasena) {
            return $this->messagesServices->clavesNoIguales();
        }

        \date_default_timezone_set('America/Bogota');
        $entity = $this->userRepository->findOneBy([
            'email' => $correo,
        ]);

        try {

            if ($id == 0) {
                return $this->createUsuario($entity, $nombre,$correo,$contrasena,$confirmar_contrasena, $estado);
            } else {
                return $this->updateUsuario($id, $nombre,$correo,$contrasena,$confirmar_contrasena, $estado);
            }
        } catch (\Exception $e) {
            // Manejo de excepciones
            return $this->messagesServices->errorGenerico();
        }
    }

    private function createUsuario(
        User   $entity = null,
        string $nombre,
        string $correo,
        string $contrasena,
        string $confirmar_contrasena,
        ?int   $estado
    ): array
    {

        if ($entity instanceof User && $entity->getId() !== 0) {
            return $this->messagesServices->registroYaExiste();

        }

        $entity = new User();
        $entity->setEmail($correo);
        $entity->setRoles(['ROLE_USER']);
        $entity->setPw($contrasena);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $entity,
            $contrasena
        );
        $entity->setEstado($estado);
        $entity->setPassword($hashedPassword);
        $this->userRepository->guardar($entity);
        $entity = new Trabajadores();
        $entity->setNombres($nombre);
        $this->trabajadoresRepository->guardar($entity);
        return $this->messagesServices->registroGuardado();
    }

    private function updateUsuario(
        int    $id,
        string $nombre,
        string $correo,
        string $contrasena,
        string $confirmar_contrasena,
        ?int   $estado
    ): array
    {

        $entity = $this->userRepository->find($id);
        $entity->setEmail($correo);
        $entity->setPw($contrasena);
        if ($entity->getRoles() !== ["ROLE_USER"]) {
            $entity->setRoles(["ROLE_ADMIN"]);
        } else {
            $entity->setRoles(["ROLE_USER"]);
        }
        $hashedPassword = $this->passwordHasher->hashPassword(
            $entity,
            $contrasena
        );
        $entity->setEstado($estado);
        $entity->setPassword($hashedPassword);
        $this->userRepository->guardar($entity);
        $entity = $this->trabajadoresRepository->find($id);
        $entity->setNombres($nombre);
        $this->trabajadoresRepository->guardar($entity);
        return $this->messagesServices->registroEditado();
    }

    public function delete(int $id): array
    {
        $entity = $this->userRepository->find($id);
        if (!$entity instanceof User) {
            return $this->messagesServices->registroNoEncontrado();
        }
        $this->userRepository->borrar($entity);
        return $this->messagesServices->registroBorrado();
    }

    public function deletes(?string $ids): array
    {
        $ids && $ids = json_decode($ids);
        try {
            $entities = $this->userRepository->findBy(['id' => $ids]);
            $this->userRepository->borrarResgistros($entities);
            return $this->messagesServices->resgistrosBorrados(count($ids));
        } catch (\Exception) {
            return $this->messagesServices->debug();
        }
    }
}