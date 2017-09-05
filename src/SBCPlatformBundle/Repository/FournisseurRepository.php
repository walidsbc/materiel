<?php

namespace SBCPlatformBundle\Repository;

/**
 * FournisseurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FournisseurRepository extends \Doctrine\ORM\EntityRepository
{
    public function getFournisseurs()
    {
        $query = $this->createQueryBuilder('f')
            ->orderBy('f.creationdate', 'DESC')
            ->getQuery();

        return $query
            ->getResult();
    }

    /**
     * Search professions by reg
     * @param $reg
     * @return array
     */
    public function findByReg($reg)
    {
        $qb = $this->createQueryBuilder('f');
        return $qb->where(
            $qb->expr()->like('f.companyname', ':companyname')
        )
            ->setParameter('companyname', '%' . $reg . '%')
            ->getQuery()
            ->getResult();
    }
}
