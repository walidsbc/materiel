<?php

namespace SBCPlatformBundle\Repository;

/**
 * InterventionCurativeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InterventionCurativeRepository extends \Doctrine\ORM\EntityRepository
{

    public function findAll()
    {
        $query = $this->createQueryBuilder('i')
            ->leftJoin('i.interferedby', 'interferedBy')
            ->addSelect('interferedBy')
            ->orderBy('i.creationdate', 'DESC')
            ->getQuery();

        return $query
            ->getResult();
    }


    public function find($id, $lockMode = null, $lockVersion = null)
    {

        $query = $this->createQueryBuilder('i')
            ->addSelect('i')
            ->leftJoin('i.natureintervention', 'natureintervention')
            ->addSelect('natureintervention')
            ->leftJoin('i.materiel', 'materiel')
            ->addSelect('materiel')
            ->leftJoin('i.interferedby', 'interferedBy')
            ->addSelect('interferedBy')
            ->where('i.id = ?1')
            ->setParameters(array(1 => $id));


        return $query->getQuery()->getOneOrNullResult();
    }
}
