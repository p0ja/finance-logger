<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Genus;
use AppBundle\Entity\Payment;
use Doctrine\ORM\EntityRepository;

class PaymentNoteRepository extends EntityRepository
{
    /**
     * @param Payment $genus
     * @return PaymentNote[]
     */
    public function findAllRecentNotesForPayment(Payment $payment)
    {
        return $this->createQueryBuilder('payment_note')
            ->andWhere('payment_note.payment = :payment')
            ->setParameter('payment', $payment)
            ->andWhere('payment_note.createdAt > :recentDate')
            ->setParameter('recentDate', new \DateTime('-3 months'))
            ->getQuery()
            ->execute();
    }
}