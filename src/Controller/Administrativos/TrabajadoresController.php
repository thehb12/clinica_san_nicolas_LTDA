<?php

namespace App\Controller\Administrativos;

use App\Services\Administrativos\TrabajadoresServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administrativos/trabajadores/', name: 'app_administrativos_trabajadores_')]
class TrabajadoresController extends AbstractController
{
    #[Route('index', name: 'index')]
    public function Index(
    ): Response
    {

        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        return $this->render('/administrativos/trabajadores.html.twig', [
            'user' => $user,
        ]);

    }

    #[Route('paginacion', name: 'paginacion')]
    public function paginacion(
        TrabajadoresServices $services
    ): JsonResponse
    {
        $json['rows'] = $services->page();
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('create_update', name: 'create_update')]
    public function create_update(
        Request          $request,
        TrabajadoresServices $services
    ): JsonResponse
    {
        $id = $request->request->get('id');
        $nombres = $request->request->get('nombres', '');
        $email = $request->request->get('email', '');
        $direccion = $request->request->get('direccion', '');
        $telefono = $request->request->get('telefono', '');
        $tipo_documento = $request->request->get('tipo_documento', 0);
        $numero_id = $request->request->get('numero_id', 0);
        $lugar_expedicion = $request->request->get('lugar_expedicion', '');
        $cargo = $request->request->get('cargo', '');
        $fecha_inicial = $request->request->get('fecha_inicial', '');
        $fecha_final = $request->request->get('fecha_final', '');
        $saldo = $request->request->get('saldo', 0);
        $auxt = $request->request->get('auxt', 0);
        $estado = $request->request->get('estado');
        $foto = null;
        if (isset($_FILES['foto'])) {
            $foto = new UploadedFile(
                $_FILES['foto']["tmp_name"],
                $_FILES['foto']["name"],
                $_FILES['foto']["type"],
                $_FILES['foto']["error"]
            );
        }

        $json = $services->create_update(
            (int)$id,
            $nombres,
            $email,
            $direccion,
            $telefono,
            $tipo_documento,
            $numero_id,
            $lugar_expedicion,
            $cargo,
            $fecha_inicial,
            $fecha_final,
            $saldo,
            $auxt,
            (int)$estado,
             $foto
        );

        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }


    #[Route('delete', name: 'delete')]
    public function delete(
        Request          $request,
        TrabajadoresServices $services
    ): JsonResponse
    {
        $id = $request->request->get('id');
        $json = $services->delete((int)$id);
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

    #[Route('deletes', name: 'deletes')]
    public function deletes(
        Request          $request,
        TrabajadoresServices $services
    ): JsonResponse
    {
        $ids = $request->request->get('ids');
        $json = $services->deletes($ids);
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

}