<?php

namespace App\Repository;

use App\Entity\CodigoUsuario;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<CodigoUsuario>
 *
 * @method CodigoUsuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method CodigoUsuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method CodigoUsuario[]    findAll()
 * @method CodigoUsuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodigoUsuarioRepository extends ServiceEntityRepository
{
       public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CodigoUsuario::class);
    }

    public function guardar(CodigoUsuario $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function borrar(CodigoUsuario $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function pagecrud(
        ?User $user = null,
    ): array
    {

        $SQL = $this->createQueryBuilder('c')
            ->select(
                'c.id id',
                'c.codigo name_codigo',
                'u.id id_usuario',
                'u.nombre name_usuario'
            )
            ->leftJoin('c.usuario', 'u')
            ->orderBy('c.id', 'asc');
        return $SQL
            ->getQuery()
            ->getArrayResult();
    }
}
