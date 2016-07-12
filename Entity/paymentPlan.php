<?php

namespace docroms\Bundle\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paymentPlan
 *
 * @ORM\Table(name="payment_plan")
 * @ORM\Entity(repositoryClass="docroms\Bundle\PaymentBundle\Repository\paymentPlanRepository")
 */
class paymentPlan
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="interval_paid", type="string", length=255)
     */
    private $intervalPaid;

    /**
     * @var string
     *
     * @ORM\Column(name="nam", type="string", length=255)
     */
    private $nam;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="curency", type="string", length=255)
     */
    private $curency;

    /**
     * @var string
     *
     * @ORM\Column(name="stripe_id", type="string", length=255)
     */
    private $stripeId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return paymentPlan
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set intervalPaid
     *
     * @param string $intervalPaid
     * @return paymentPlan
     */
    public function setIntervalPaid($intervalPaid)
    {
        $this->intervalPaid = $intervalPaid;
    
        return $this;
    }

    /**
     * Get intervalPaid
     *
     * @return string 
     */
    public function getIntervalPaid()
    {
        return $this->intervalPaid;
    }

    /**
     * Set nam
     *
     * @param string $nam
     * @return paymentPlan
     */
    public function setNam($nam)
    {
        $this->nam = $nam;
    
        return $this;
    }

    /**
     * Get nam
     *
     * @return string 
     */
    public function getNam()
    {
        return $this->nam;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return paymentPlan
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set curency
     *
     * @param string $curency
     * @return paymentPlan
     */
    public function setCurency($curency)
    {
        $this->curency = $curency;

        return $this;
    }

    /**
     * Get curency
     *
     * @return string
     */
    public function getCurency()
    {
        return $this->curency;
    }

    /**
     * Set stripeId
     *
     * @param string $id
     * @return paymentPlan
     */
    public function setStripeId($id)
    {
        $this->stripeId = $id;

        return $this;
    }

    /**
     * Get StripeId
     *
     * @return string
     */
    public function getStripeId()
    {
        return $this->stripeId;
    }
}
