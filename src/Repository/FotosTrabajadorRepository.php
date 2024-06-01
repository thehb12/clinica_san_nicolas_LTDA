<?php

namespace App\Repository;

use App\Entity\FotosTrabajador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FotosTrabajador>
 *
 * @method FotosTrabajador|null find($id, $lockMode = null, $lockVersion = null)
 * @method FotosTrabajador|null findOneBy(array $criteria, array $orderBy = null)
 * @method FotosTrabajador[]    findAll()
 * @method FotosTrabajador[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FotosTrabajadorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FotosTrabajador::class);
    }

    public function guardar(FotosTrabajador $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function borrar(FotosTrabajador $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }
}
