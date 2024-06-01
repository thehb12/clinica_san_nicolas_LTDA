<?php

namespace App\Controller\Configuracion;

use App\Services\Configuracion\UsuariosServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Configuracion/Usuarios/', name: 'app_configuracion_usuarios_')]
class UsuariosController extends AbstractController
{

    #[Route('index', name: 'index')]
    public function index(
        Request $request
    ): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        return $this->render('/configuracion/usuarios.html.twig', [
            'user' => $user,
        ]);

    }

    #[Route('paginacion', name: 'paginacion')]
    public function paginacion(
        UsuariosServices $services
    ): JsonResponse
    {
        $json['rows'] = $services->page();
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('create_update', name: 'create_update')]
    public function create_update(
        Request          $request,
        UsuariosServices $services
    ): JsonResponse
    {
        $id = $request->request->get('id');
        $nombre = $request->request->get('nombre');
        $correo = $request->request->get('correo');
        $contrasena = $request->request->get('contrasena');
        $confirmar_contrasena = $request->request->get('confirmar_contrasena');
        $estado = $request->request->get('estado');
        $json = $services->create_update((int)$id, $nombre, $correo, $contrasena, $confirmar_contrasena, (int)$estado);
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('delete', name: 'delete')]
    public function delete(
        Request          $request,
        UsuariosServices $services
    ): JsonResponse
    {
        $id = $request->request->get('id');
        $json = $services->delete((int)$id);
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('deletes', name: 'deletes')]
    public function deletes(
        Request          $request,
        UsuariosServices $services
    ): JsonResponse
    {
        $ids = $request->request->get('ids');
        $json = $services->deletes($ids);
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

}