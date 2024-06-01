<?php

namespace App\Controller\Configuracion;

use App\Services\Configuracion\CodigosUsuariosServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Configuracion/Codigos/Usuarios/', name: 'app_configuracion_codigos_usuarios_')]
class CodigosUsuariosController extends AbstractController
{

    #[Route('Index', name: 'index')]
    public function index(
        Request $request
    ): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        return $this->render('/configuracion/codigosusuarios.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('Page', name: 'page')]
    public function page(
        CodigosUsuariosServices $services
    ): JsonResponse
    {
        $json['rows'] = $services->page();
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

}