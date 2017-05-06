<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class SubPaymentRepository extends EntityRepository
{
    public function createAlphabeticalQueryBuilder()
    {
        return $this->createQueryBuilder('sub_payment')
            ->orderBy('sub_payment.name', 'ASC');
    }
}