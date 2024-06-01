<?php

namespace App\Controller\Administrativos;

use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administrativos/notificacion/no/renovacion/', name: 'app_administrativos_no_renovacion_')]
class NorenovacionController extends AbstractController
{
    #[Route('index', name: 'index')]
    public function index(): Response
    {

        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        return $this->render('/administrativos/norenovacion.html.twig', [
            'user' => $user,
        ]);

    }

    #[Route('obtener_cedula', name: 'obtener_cedula')]
    public function obtener_cedula(
        Request        $request,
        UserRepository $repository,
    ): JsonResponse
    {
        $cedula = $request->request->get('cedula', '');
        $json = $repository->buscarCedula($cedula);

        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);

    }

    #[Route('generar_pdf/{id}', name: 'pdf')]
    public function GenerarPDF(
        $id,
        UserRepository $userRepository
    ): Response
    {
        $datos = $userRepository->datos_pdf($id);
        \date_default_timezone_set('America/Bogota');
        $fechaActual = date("d M Y H:i:s");

        $dompdf = new Dompdf();
        $dompdf->setPaper('letter', 'portrait');
        $options = $dompdf->getOptions();
        $options->set('isPhpEnabled', false);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true); // Habilitar PHP si es necesario
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        // Permitir la carga de imágenes desde rutas locales
        $options->set('isPhpEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);

        $html = $this->renderView('pdf/norenovacion.html.twig', [
            'datos' => $datos[0],
            'fecha' => $fechaActual
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response($dompdf->stream('Norenovacion.pdf', ["Attachment" => true]), Response::HTTP_OK, ['Content-Type' => 'application/pdf']);
    }
}