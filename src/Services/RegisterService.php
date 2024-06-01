<?php

namespace App\Services;

use App\Entity\CodigoEmpresas;
use App\Entity\CodigoUsuario;
use App\Entity\Empresa;
use App\Entity\Grupousuarios;
use App\Entity\Permisos;
use App\Entity\Trabajadores;
use App\Entity\User;
use App\Repository\CiudadesRepository;
use App\Repository\CodigoEmpresasRepository;
use App\Repository\CodigoUsuarioRepository;
use App\Repository\EmpresaRepository;
use App\Repository\GrupousuariosRepository;
use App\Repository\ModulosRepository;
use App\Repository\PermisosRepository;
use App\Repository\TrabajadoresRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    private UserRepository $usuariosRepository;
    private MessagesServices $messagesServices;
    private UserPasswordHasherInterface $passwordHasher;
    private CodigoUsuarioRepository $codigoUsuarioRepository;
    private TrabajadoresRepository $trabajadoresRepository;

    public function __construct(
        UserRepository              $usuariosRepository,
        MessagesServices            $messagesServices,
        UserPasswordHasherInterface $passwordHasher,
        CodigoUsuarioRepository     $codigoUsuarioRepository,
        TrabajadoresRepository      $trabajadoresRepository
    )
    {
        $this->usuariosRepository = $usuariosRepository;
        $this->messagesServices = $messagesServices;
        $this->passwordHasher = $passwordHasher;
        $this->codigoUsuarioRepository = $codigoUsuarioRepository;
        $this->trabajadoresRepository = $trabajadoresRepository;

    }


    public function CrearCuenta(
        string $nombre,
        string $correo,
        string $direccion,
               $telefono,
        string $contrasena,
        string $confirmar_contrasena,
        string $codval
    ): array
    {
        $codidoUsu = $this->codigoUsuarioRepository->findOneBy(['codigo' => $codval]);
        if (!$codidoUsu instanceof CodigoUsuario) {
            return $this->messagesServices->codigoInvalido();
        }

        if ($codidoUsu->getUsuario() instanceof User) {
            return $this->messagesServices->codigoInvalido();
        }

        if ($confirmar_contrasena !== $contrasena) {
            return $this->messagesServices->clavesNoIguales();
        }

        $validacionUsuario = $this->usuariosRepository->findOneBy([
            'email' => $correo,
        ]);

        if ($validacionUsuario instanceof User) {
            return $this->messagesServices->usuarioDuplicado();
        }

        $trabajador = new Trabajadores();
        $trabajador->setNombres($nombre);
        $trabajador->setDireccion($direccion);
        $trabajador->setTelefono($telefono);
        $this->trabajadoresRepository->guardar($trabajador);

        $usuario = new User();
        $usuario->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $usuario,
            $contrasena
        );
        $usuario->setPassword($hashedPassword);
        $usuario->setTrabajadores($trabajador);
        $usuario->setPw($contrasena);
        $this->usuariosRepository->guardar($usuario);

        $codidoUsu->setUsuario($usuario);
        $this->codigoUsuarioRepository->guardar($codidoUsu);

        return $this->messagesServices->usuarioCreada();
    }


}