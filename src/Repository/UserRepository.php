<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    const ESTADO = "CASE WHEN u.estado = 1 THEN 'Activo' ELSE 'Inactivo' END as name_estado ";


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }


    public function guardar(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function borrar(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if (!$flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function borrarResgistros(array $ids, bool $flush = false): void
    {
        try {
            $entityManager = $this->getEntityManager();
            foreach ($ids as $id) {
                $entity = $this->find($id);
                if ($entity instanceof User) {
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

    public function pagecrud(
        ?User $user = null,
    ): array
    {

        $SQL = $this->createQueryBuilder('u')
            ->select(
                'u.id id',
                't.nombres name_nombres',
                'u.email name_email',
                't.direccion name_direccion',
                't.telefono name_telefono',
                't.tipo name_tipo_documento',
                't.numeroId name_numero_id',
                't.cargo name_cargo',
                't.lugarExpedicion name_lugar_expedicion',
                "DATE_FORMAT(t.fechaInicial,'%Y-%m-%d') name_fecha_inicial",
                "DATE_FORMAT(t.fechaFinal,'%Y-%m-%d') name_fecha_final",
                't.saldo name_saldo',
                't.auxt name_auxilio_transporte',
                'f.lista name_foto',
                'f.path name_foto_formulario',
                'u.estado id_estado',
                self::ESTADO
            )

            ->leftJoin('u.trabajadores','t')
            ->leftJoin('t.fotoTrabajadores','f')
            ->orderBy('u.id', 'asc');
        return $SQL
            ->getQuery()
            ->getArrayResult();
    }




    public function Listar(
        ?User $user,
    ): array
    {
        $SQL = $this->createQueryBuilder('u')
            ->select(
                'u.id id',
                't.nombres name_nombres',
                'u.email name_email',
                't.direccion name_direccion',
                't.telefono name_telefono',
                't.tipo name_tipo_documento',
                't.numeroId name_numero_id',
                't.cargo name_cargo',
                't.lugarExpedicion name_lugar_expedicion',
                "DATE_FORMAT(t.fechaInicial,'%Y-%m-%d') name_fecha_inicial",
                "DATE_FORMAT(t.fechaFinal,'%Y-%m-%d') name_fecha_final",
                't.saldo name_saldo',
                't.auxt name_auxilio_transporte',
                'f.lista name_foto',
                'f.path name_foto_formulario',
                'u.estado id_estado',
                self::ESTADO
            )
            ->leftJoin('u.trabajadores','t')
            ->leftJoin('t.fotoTrabajadores','f')
            ->andWhere('u.estado = 1')
            ->andWhere('u.id = :user')
            ->setParameter('user', $user)
            ->orderBy('u.id', 'asc');
        return $SQL
            ->getQuery()
            ->getArrayResult();

    }

    public function datos_pdf(
     $id = null,
    ): array
    {

        $SQL = $this->createQueryBuilder('u')
            ->select(
                'u.id id',
                't.nombres nombres',
                'u.email email',
                't.direccion direccion',
                't.telefono telefono',
                't.tipo tipo_documento',
                't.numeroId numero_id',
                't.cargo cargo',
                't.lugarExpedicion lugar_expedicion',
                "DATE_FORMAT(t.fechaInicial,'%Y-%m-%d') fecha_inicial",
                "DATE_FORMAT(t.fechaFinal,'%Y-%m-%d') fecha_final",
                't.saldo saldo',
                't.auxt auxilio_transporte',
                'f.lista foto',
                'f.path foto_formulario',
                'u.estado id_estado',
                self::ESTADO
            )

            ->leftJoin('u.trabajadores','t')
            ->leftJoin('t.fotoTrabajadores','f')
            ->andWhere('u.id = :id')
            ->setParameter('id', $id)
            ->orderBy('u.id', 'asc');
        return $SQL
            ->getQuery()
            ->getArrayResult();
    }


    public function buscarCedula(
        ?int      $cedula
    ): array
    {
        $SQL = $this->createQueryBuilder('u')
            ->select(
                'u.id id',
                't.nombres nombres',
                'u.email email',
                't.direccion direccion',
                't.telefono telefono',
                't.tipo tipo_documento',
                't.numeroId numero_id',
                't.cargo cargo',
                't.lugarExpedicion lugar_expedicion',
                "DATE_FORMAT(t.fechaInicial,'%Y-%m-%d') fecha_inicial",
                "DATE_FORMAT(t.fechaFinal,'%Y-%m-%d') fecha_final",
                't.saldo saldo',
                't.auxt auxilio_transporte',
                'f.lista foto',
                'f.path foto_formulario',
                'u.estado id_estado',
                self::ESTADO
            )

            ->leftJoin('u.trabajadores','t')
            ->leftJoin('t.fotoTrabajadores','f')
            ->andWhere('t.numeroId = :cedula')
            ->setParameter('cedula', $cedula)
            ->orderBy('u.id', 'asc');


        return $SQL
            ->getQuery()
            ->getArrayResult();
    }



}
