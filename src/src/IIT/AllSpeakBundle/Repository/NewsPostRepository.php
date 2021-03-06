<?php

namespace IIT\AllSpeakBundle\Repository;

/**
 * NewsPostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsPostRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAll(int $limit = null)
    {
        return $this->findBy([], array('ts' => 'DESC'), $limit);
    }
}
