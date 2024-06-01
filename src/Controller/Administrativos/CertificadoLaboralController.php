<?php

namespace App\Controller\Administrativos;

use App\Repository\UserRepository;
use Dompdf\Dompdf;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/administrativos/certificado/laboral/', name: 'app_administrativos_certificado_laboral_')]
class CertificadoLaboralController extends AbstractController
{

    #[Route('index', name: 'index')]
    public function index(
    ): Response
    {

        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        return $this->render('/administrativos/certificado_laboral.html.twig', [
            'user' => $user,
        ]);

    }

    #[Route('generar_pdf', name: 'pdf')]
    public function GenerarPDF(

        UserRepository $userRepository
    ): Response
    {

        $user = $this->getUser();
        $datos = $userRepository->datos_pdf($user);
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

        $html = $this->renderView('pdf/certificado_laboral.html.twig', [
            'datos' => $datos[0],
            'fecha' => $fechaActual
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response($dompdf->stream('CertificadoLaboral.pdf', ["Attachment" => true]), Response::HTTP_OK, ['Content-Type' => 'application/pdf']);
    }


}