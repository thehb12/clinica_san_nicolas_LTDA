<?php

namespace App\Controller;

use App\Repository\TrabajadoresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/autocomplete/', name: 'autocomplete_')]
class AutoCompleteController extends AbstractController
{
    #[Route('nombre_usuario', name: 'nombre_usuario')]
    public function nombre_usuario(
        Request            $request,
        TrabajadoresRepository $repository
    ): JsonResponse
    {
        $term = $request->query->get('term', '');
        $json = $repository->cedula($term);

        return new JsonResponse($json, 200, ['Content-Type' => 'application/json']);
    }

}