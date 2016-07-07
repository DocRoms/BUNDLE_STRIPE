<?php

namespace docroms\Bundle\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paymentTransaction
 *
 * @ORM\Table(name="payment_transaction")
 * @ORM\Entity(repositoryClass="Payment\PaymentBundle\Repository\paymentTransactionRepository")
 */
class paymentTransaction
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
     * @ORM\Column(name="profile_payment_id", type="integer")
     */
    private $profilePayementId;

    /**
     * @var int
     *
     * @ORM\Column(name="order_id", type="integer", nullable=true)
     */
    private $orderId;

    /**
     * @var int
     *
     * @ORM\Column(name="plan_id", type="integer", nullable=true)
     */
    private $planId;

    /**
     * @var int
     *
     * @ORM\Column(name="cupon_id", type="integer", nullable=true)
     */
    private $cuponId;


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
     * Set profilePayementId
     *
     * @param integer $profilePayementId
     * @return paymentTransaction
     */
    public function setProfilePayementId($profilePayementId)
    {
        $this->profilePayementId = $profilePayementId;
    
        return $this;
    }

    /**
     * Get profilePayementId
     *
     * @return integer 
     */
    public function getProfilePayementId()
    {
        return $this->profilePayementId;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     * @return paymentTransaction
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->orderId;
    }


    /**
     * Set planId
     *
     * @param integer $planId
     * @return paymentTransaction
     */
    public function setPlanId($planId)
    {
        $this->planId = $planId;

        return $this;
    }

    /**
     * Get planId
     *
     * @return integer
     */
    public function getPlanId()
    {
        return $this->planId;
    }

    /**
     * Set cuponId
     *
     * @param integer $cuponId
     * @return paymentTransaction
     */
    public function setCuponId($cuponId)
    {
        $this->cuponId = $cuponId;
    
        return $this;
    }

    /**
     * Get cuponId
     *
     * @return integer 
     */
    public function getCuponId()
    {
        return $this->cuponId;
    }
}
