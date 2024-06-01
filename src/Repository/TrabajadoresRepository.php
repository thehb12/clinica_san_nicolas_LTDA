<?php

namespace App\Repository;

use App\Entity\Trabajadores;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trabajadores>
 *
 * @method Trabajadores|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trabajadores|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trabajadores[]    findAll()
 * @method Trabajadores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrabajadoresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trabajadores::class);
    }

    public function guardar(Trabajadores $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function borrar(Trabajadores $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function borrarResgistros(array $ids, bool $flush = false): void
    {
        try {
            $entityManager = $this->getEntityManager();
            foreach ($ids as $id) {
                $entity = $this->find($id);
                if ($entity instanceof Trabajadores) {
                    $entityManager->remove($entity);
                }
            }
            if (!$flush) {
                $entityManager->flush();
            }
        } catch (\Exception $e) {
            // Manejar la excepción según sea necesario
            throw $e;
        }
    }

    public function cedula(
        $term
    ): array
    {
        $SQL = $this->createQueryBuilder('t')
            ->select(
                't.id id',
                't.numeroId value'
            )
            ->andWhere('t.estado = 1');
        $SQL->andWhere($SQL->expr()->like('t.numeroId', ':term'))
            ->setParameter('term', "%" . $term . "%");
        return $SQL
            ->getQuery()
            ->getArrayResult();
    }


}
