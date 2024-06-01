<?php

namespace App\Services\Configuracion;


use App\Entity\FotosTrabajador;
use App\Repository\FotosTrabajadorRepository;
use App\Repository\TrabajadoresRepository;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use App\Services\MessagesServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PerfilServices extends AbstractController
{
    private MessagesServices $messagesServices;
    private UserRepository $userRepository;
    private TrabajadoresRepository $trabajadoresRepository;
    private FileUploader $fileUploader;
    private FotosTrabajadorRepository $fotosTrabajadorRepository;

    public function __construct(
        MessagesServices $messagesServices,
        UserRepository   $userRepository,
        TrabajadoresRepository $trabajadoresRepository,
        FileUploader $fileUploader,
        FotosTrabajadorRepository $fotosTrabajadorRepository
    )
    {
        $this->messagesServices = $messagesServices;
        $this->userRepository = $userRepository;
        $this->trabajadoresRepository = $trabajadoresRepository;
        $this->fileUploader = $fileUploader;
        $this->fotosTrabajadorRepository = $fotosTrabajadorRepository;
    }

    public function create_update(
        int    $id,
        string $nombre,
               $telefono,
        string $direccion,
        string $correo,
        $foto
    ): array
    {

        \date_default_timezone_set('America/Bogota');
        $entity = $this->userRepository->find($id);
        $entity->setEmail($correo);
        $this->userRepository->guardar($entity);
        $entity = $this->trabajadoresRepository->find($id);
        $entity->setNombres($nombre);
        $entity->setDireccion($direccion);
        $entity->setTelefono($telefono);
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
        return $this->messagesServices->usuarioPerfil();
    }


}