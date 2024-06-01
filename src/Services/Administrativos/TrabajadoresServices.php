<?php

namespace App\Services\Administrativos;

use App\Entity\FotosTrabajador;
use App\Entity\Trabajadores;
use App\Entity\User;
use App\Repository\FotosTrabajadorRepository;
use App\Repository\TrabajadoresRepository;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use App\Services\MessagesServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TrabajadoresServices extends AbstractController
{

    private UserRepository $userRepository;
    private MessagesServices $messagesServices;
    private UserPasswordHasherInterface $passwordHasher;
    private TrabajadoresRepository $trabajadoresRepository;
    private FileUploader $fileUploader;
    private FotosTrabajadorRepository $fotosTrabajadorRepository;

    public function __construct(
        UserRepository              $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        MessagesServices            $messagesServices,
        TrabajadoresRepository $trabajadoresRepository,
        FileUploader $fileUploader,
        FotosTrabajadorRepository $fotosTrabajadorRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->messagesServices = $messagesServices;
        $this->trabajadoresRepository = $trabajadoresRepository;
        $this->fileUploader = $fileUploader;
        $this->fotosTrabajadorRepository = $fotosTrabajadorRepository;
    }


    public function page(): array
    {
        return $this->userRepository->pagecrud($this->getUser());
    }

    public function create_update(
        int    $id,
        string $nombres,
        string $email,
        string $direccion,
               $telefono,
        string $tipo_documento,
        string $numero_id,
        string $lugar_expedicion,
        string $cargo,
               $fecha_inicial,
               $fecha_final,
        float  $saldo,
        string $auxt,
        ?int   $estado,
        $foto
    ): array
    {
        \date_default_timezone_set('America/Bogota');
        $entity = $this->userRepository->findOneBy([
            'email' => $email,

        ]);


        try {

            if ($id == 0) {
                return $this->create(
                    $entity,$nombres, $email,
                    $direccion, $telefono,$tipo_documento,
                    $numero_id, $lugar_expedicion,
                    $cargo, $fecha_inicial,
                    $fecha_final, $saldo, $auxt, $estado,
                    $foto
                );
            } else {
                return $this->update(
                    $id, $nombres, $email,
                    $direccion, $telefono,$tipo_documento,
                    $numero_id, $lugar_expedicion,
                    $cargo, $fecha_inicial,
                    $fecha_final, $saldo, $auxt, $estado,
                    $foto
                );
            }
        } catch (\Exception $e) {
            // Manejo de excepciones
            return $this->messagesServices->errorGenerico();
        }
    }

    /**
     * @throws \Exception
     */
    private function create(
        User $entity = null,
        string $nombres,
        string $email,
        string $direccion,
               $telefono,
        string $tipo_documento,
        string $numero_id,
        string $lugar_expedicion,
        string $cargo,
               $fecha_inicial,
               $fecha_final,
        float  $saldo,
        string $auxt,
        ?int     $estado,
        $foto
    ): array
    {

        if ($entity instanceof User && $entity->getId() !== 0) {
            return $this->messagesServices->registroYaExiste();
        }

        $tra = new Trabajadores();
        $tra->setUsuCreate($this->getUser());
        $tra->setNombres($nombres);
        $tra->setDireccion($direccion);
        $tra->setTelefono($telefono);
        $tra->setTipo($tipo_documento);
        $tra->setCargo($cargo);
        $tra->setNumeroId($numero_id);
        $tra->setLugarExpedicion($lugar_expedicion);
        $tra->setSaldo($saldo);
        $tra->setAuxt($auxt);
        $tra->setFechaFinal(new \DateTime($fecha_final));
        $tra->setFechaInicial(new \DateTime($fecha_inicial));
        $tra->setEstado($estado);
        $this->trabajadoresRepository->guardar($tra);

        if ($foto instanceof UploadedFile && $foto->getFilename() != "") {
            if ($tra->getFotoTrabajadores() instanceof FotosTrabajador) {
                $this->fileUploader->removUploadFoto($tra->getFotoTrabajadores()->getPath());
            }
            $FileName = $this->fileUploader->upload($foto);
            $fotoEntity = new FotosTrabajador();

            $fotoEntity->setName($FileName);
            $old_foto = $tra->getFotoTrabajadores();
            $tra->setFotoTrabajadores($fotoEntity);
            if ($old_foto instanceof FotosTrabajador) {
                $this->FotosTrabajadorRepository->borrar($old_foto);
            }
        }

        $entity = new User();
        $entity->setUsuCreate($this->getUser());
        $entity->setEmail($email);
        $entity->setPw($numero_id);
        $entity->setRoles(['ROLE_USER']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $entity,
            $numero_id
        );
        $entity->setPassword($hashedPassword);
        $entity->setEstado($estado);
        $entity->setTrabajadores($tra);
        $this->userRepository->guardar($entity);

        return $this->messagesServices->registroGuardado();
    }

    /**
     * @throws \Exception
     */
    private function update(
        int    $id,
        string $nombres,
        string $email,
        string $direccion,
               $telefono,
        string $tipo_documento,
        string $numero_id,
        string $lugar_expedicion,
        string $cargo,
               $fecha_inicial,
               $fecha_final,
        float  $saldo,
        string $auxt,
        ?int  $estado,
        $foto
    ): array
    {

        $entity = $this->userRepository->find($id);
        $entity->setUsuUpdate($this->getUser());
        $entity->setEmail($email);
        $entity->setEstado($estado);
        $entity->setPw($numero_id);
        $this->userRepository->guardar($entity);
        $entity = $this->trabajadoresRepository->find($id);
        $entity->setUsuUpdate($this->getUser());
        $entity->setNombres($nombres);
        $entity->setDireccion($direccion);
        $entity->setTelefono($telefono);
        $entity->setTipo($tipo_documento);
        $entity->setCargo($cargo);
        $entity->setNumeroId($numero_id);
        $entity->setLugarExpedicion($lugar_expedicion);
        $entity->setSaldo($saldo);
        $entity->setAuxt($auxt);
        $entity->setFechaFinal(new \DateTime($fecha_final));
        $entity->setFechaInicial(new \DateTime($fecha_inicial));
        $entity->setEstado($estado);

        if ($foto instanceof UploadedFile && $foto->getFilename() != "") {
            if ($entity->getFotoTrabajadores() instanceof FotosTrabajador) {
                $this->fileUploader->removUploadFoto($entity->getFotoTrabajadores()->getPath());
            }
            $FileName = $this->fileUploader->upload($foto);
            $fotoEntity = new FotosTrabajador();
            $fotoEntity->setName($FileName);
            $old_foto = $entity->getFotoTrabajadores();
            $entity->setFotoTrabajadores($fotoEntity);
            if ($old_foto instanceof FotosTrabajador) {
                $this->fotosTrabajadorRepository->borrar($old_foto);
            }
        }
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

        $entity = $this->trabajadoresRepository->find($id);
        if (!$entity instanceof Trabajadores) {
            return $this->messagesServices->registroNoEncontrado();
        }
        $this->trabajadoresRepository->borrar($entity);
        return $this->messagesServices->registroBorrado();
    }

    public function deletes(?string $ids): array
    {
        // Decodificar los IDs de JSON si $ids no es nulo
        $ids && $ids = json_decode($ids);

        try {
            
            // Buscar y eliminar registros de la primera entidad (userRepository)
            if ($ids) {
                $entities = $this->userRepository->findBy(['id' => $ids]);
                $this->userRepository->borrarResgistros($entities);
            }

            // Buscar y eliminar registros de la segunda entidad (trabajadoresRepository)
            if ($ids) {
                $entities = $this->trabajadoresRepository->findBy(['id' => $ids]);
                $this->trabajadoresRepository->borrarResgistros($entities);
            }


            // Retornar un mensaje indicando la cantidad de registros borrados
            return $this->messagesServices->resgistrosBorrados(count($ids));
        } catch (\Exception $e) {
            // Retornar un mensaje de depuración en caso de error
            return $this->messagesServices->debug();
        }
    }


}