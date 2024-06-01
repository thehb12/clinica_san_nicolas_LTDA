<?php

namespace App\Services;

use App\Entity\Visitas;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\RequestStack;

class IPLoggerService
{
    private $entityManager;
    private $requestStack;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function logIP(): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $ip = $request->getClientIp();

        $visitasRepository = $this->entityManager->getRepository(Visitas::class);
        $existingVisita = $visitasRepository->findOneBy(['ip' => $ip]);

        // Verificar si existe una visita anterior con la misma IP
        if ($existingVisita) {
            // Verificar si han pasado al menos 4 horas desde la última visita
            $lastVisitTime = $existingVisita->getFecha();
            $fourHoursAgo = new \DateTime('-4 hours');
            if ($lastVisitTime < $fourHoursAgo) {
                // Si han pasado al menos 4 horas, crear una nueva visita
                $this->createNewVisit($ip);
            }
        } else {
            // Si no hay visitas anteriores, crear una nueva visita
            $this->createNewVisit($ip);
        }
    }

    private function createNewVisit(string $ip): void
    {
        $visita = new Visitas();
        $visita->setIp($ip);
        $visita->setFecha(new \DateTime());
        $this->entityManager->persist($visita);
        $this->entityManager->flush();
    }
}