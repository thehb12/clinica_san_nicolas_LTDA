<?php

namespace App\Controller\Configuracion;

use App\Repository\UserRepository;
use App\Services\Configuracion\ResetPasswordServices;
use App\Services\MessagesServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/Configuracion/Reset/', name: 'app_configuracion_reset_')]
class ResetPasswordController extends AbstractController
{
    #[Route('Password', name: 'password')]
    public function cambiarClave():Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        \date_default_timezone_set('America/Bogota');
        $fechaActual = date("d M Y H:i:s");
        return $this->render('configuracion/resetpasswordhtml.twig', [
            'user' => $user,
            'tiempo' => $fechaActual,
        ]);
    }

    #[Route('crud', name: 'crud')]
    public function crud(
        Request                     $request,
        MessagesServices            $messages,
        ResetPasswordServices       $services,
        UserRepository              $repository

    )
    {
        $user = $repository->find($this->getUser());
        $services->setOldPass($request->request->get('oldClave', ''));
        $services->setNewPass($request->request->get('newClave', ''));
        $services->setRepeatPass($request->request->get('repitClave', ''));
        $services->setUser($user);
        if ($services->isFromIncompleto()) {
            $json = $messages->formImcompleto();
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
        }
        if ($services->isPassNoSonIguales()) {
            $json = $messages->clavesNoIguales();
            return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
        }

        if ($services->isPassOldValido()) {
            $services->cambiarPassword();
            $json = $messages->claveCambiada();
        } else {
            $json = $messages->claveAnteriorIncorrecta();
        }
        $json["id"] = $user->getId();
        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

}