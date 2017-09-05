<?php

namespace SBCPlatformBundle\Repository;

/**
 * InterventionPreventiveRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InterventionPreventiveRepository extends \Doctrine\ORM\EntityRepository
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
            ->leftJoin('i.interferedby', 'interferedBy')
            ->addSelect('interferedBy')
            ->leftJoin('i.planificationPreventive', 'planificationpreventive')
            ->addSelect('planificationpreventive')
            ->leftJoin('planificationpreventive.materiel', 'materiel')
            ->addSelect('materiel')
            ->leftJoin('planificationpreventive.natureintervention', 'natureintervention')
            ->addSelect('natureintervention')
            ->where('i.id = ?1')
            ->setParameters(array(1 => $id));


        return $query->getQuery()->getOneOrNullResult();
    }
}
