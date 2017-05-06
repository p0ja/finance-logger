<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentRepository")
 * @ORM\Table(name="payment")
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="SubPayment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subPayment;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(min=0, minMessage="Negative payments! Come on...")
     * @ORM\Column(type="integer")
     */
    private $paymentsCount;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $descriptFact;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = true;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="date")
     */
    private $committedAt;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateType
     */
    public function getCommittedAt()
    {
        return $this->committedAt;
    }

    /**
     * @param mixed $committedAt
     */
    public function setCommittedAt($committedAt)
    {
        $this->committedAt = $committedAt;
    }

    /**
     * @ORM\OneToMany(targetEntity="PaymentNote", mappedBy="payment")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|PaymentNote[]
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @return boolean
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param boolean $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return SubPayment
     */
    public function getSubPayment()
    {
        return $this->subPayment;
    }

    /**
     * @param SubPayment $subPayment
     */
    public function setSubPayment($subPayment)
    {
        $this->subPayment = $subPayment;
    }

    /**
     * @return integer
     */
    public function getPaymentCount()
    {
        return $this->paymentsCount;
    }

    /**
     * @param integer $paymentsCount
     */
    public function setPaymentsCount($paymentsCount)
    {
        $this->paymentsCount = $paymentsCount;
    }

    /**
     * @return string
     */
    public function getDescriptFact()
    {
        return $this->descriptFact;
    }

    /**
     * @param string $descriptFact
     */
    public function setDescriptFact($descriptFact)
    {
        $this->descriptFact = $descriptFact;
    }
}