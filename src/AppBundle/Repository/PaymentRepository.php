<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Payment;
use Doctrine\ORM\EntityRepository;

class PaymentRepository extends EntityRepository
{
    /**
     * @return Payment[]
     */
    public function findAllPublishedOrderedByRecentlyActive()
    {
        return $this->createQueryBuilder('payment')
            ->andWhere('payment.isPublished = :isPublished')
            ->setParameter('isPublished', true)
            ->leftJoin('payment.notes', 'payment_note')
            ->orderBy('payment_note.createdAt', 'DESC')
            ->getQuery()
            ->execute();
    }

}