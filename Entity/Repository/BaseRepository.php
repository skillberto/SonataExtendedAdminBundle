<?php

namespace Skillberto\AdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
    public function getMaxPosition($entity)
    {
        $query = $this
                ->getEntityManager()
                ->createQuery('SELECT MAX(m.position) p FROM '.$entity.' m');
        try {
            return $query->getSingleScalarResult();
        } catch( Doctrine\ORM\NoResultException $e) {
            return 0;
        }
    }
}
