<?php

namespace App\Controller;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

#[Route('/dashboard/', name: 'app_')]
class DashboardController extends AbstractController
{

    #[Route('index', name: 'dashboard')]
    public function index(
    ): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
        ]);
    }

}
