<?php

namespace App\Controller\Configuracion;
use App\Repository\UserRepository;
use App\Services\Configuracion\PerfilServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Configuracion/Perfil/', name: 'app_configuracion_perfil_')]
class PerfilController extends AbstractController
{
    #[Route('Index', name: 'index')]
    public function Perfil(): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        \date_default_timezone_set('America/Bogota');
        $fechaActual = date("d M Y H:i:s");
        return $this->render('configuracion/perfil.html.twig', [
            'user' => $user,
            'tiempo' => $fechaActual,
        ]);
    }


    #[Route('Lista', name: 'lista')]
    public function Lista(
        Request        $request,
        UserRepository $repository
    )
    {
        $json = $repository->Listar($this->getUser());
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('crud', name: 'crud')]
    public function crud(
        Request        $request,
        PerfilServices $services

    )
    {
        $id = $request->request->get('id');
        $nombre = $request->request->get('nombre','');
        $telefono = $request->request->get('telefono','');
        $direccion = $request->request->get('direccion','');
        $correo = $request->request->get('correo','');
        $foto = null;
        if (isset($_FILES['foto'])) {
            $foto = new UploadedFile(
                $_FILES['foto']["tmp_name"],
                $_FILES['foto']["name"],
                $_FILES['foto']["type"],
                $_FILES['foto']["error"]
            );
        }


        $json = $services->create_update((int)$id, $nombre, $telefono, $direccion, $correo,$foto);
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

}