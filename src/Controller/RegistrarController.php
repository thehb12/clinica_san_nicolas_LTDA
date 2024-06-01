<?php

namespace App\Controller;

use App\Services\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/', name: 'app_')]
class RegistrarController extends AbstractController
{

    #[Route('registrar', name: 'registrar')]
    public function Registrar(

    ): Response
    {
        return $this->render('security/registrar.html.twig', []);
    }

    #[Route('crud', name: 'crud')]
    public function crud(
        Request         $request,
        RegisterService $registerService
    ): JsonResponse
    {
        $nombre = $request->request->get('nombre', '');
        $correo = $request->request->get('correo', '');
        $direccion = $request->request->get('direccion', '');
        $telefono = $request->request->get('telefono');
        $contrasena = $request->request->get('contrasena', '');
        $confirmar_contrasena = $request->request->get('confirmar_contrasena', '');
        $codval = $request->request->get('codval', '');

        $json = $registerService->CrearCuenta(
            $nombre,
            $correo,
            $direccion,
            $telefono,
            $contrasena,
            $confirmar_contrasena,
            $codval
        );

        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }
}