<?php

namespace Payment\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paymentCoupon
 *
 * @ORM\Table(name="payment_coupon")
 * @ORM\Entity(repositoryClass="Payment\PaymentBundle\Repository\paymentCouponRepository")
 */
class paymentCoupon
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
     * @ORM\Column(name="amount_off", type="integer", nullable=true)
     */
    private $amountOff;

    /**
     * @var int
     *
     * @ORM\Column(name="prcent_off", type="integer")
     */
    private $prcentOff;

    /**
     * @var int
     *
     * @ORM\Column(name="times_redeemed", type="integer", nullable=true)
     */
    private $timesRedeemed;


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
     * Set amountOff
     *
     * @param integer $amountOff
     * @return paymentCoupon
     */
    public function setAmountOff($amountOff)
    {
        $this->amountOff = $amountOff;
    
        return $this;
    }

    /**
     * Get amountOff
     *
     * @return integer 
     */
    public function getAmountOff()
    {
        return $this->amountOff;
    }

    /**
     * Set prcentOff
     *
     * @param integer $prcentOff
     * @return paymentCoupon
     */
    public function setPrcentOff($prcentOff)
    {
        $this->prcentOff = $prcentOff;
    
        return $this;
    }

    /**
     * Get prcentOff
     *
     * @return integer 
     */
    public function getPrcentOff()
    {
        return $this->prcentOff;
    }

    /**
     * Set timesRedeemed
     *
     * @param integer $timesRedeemed
     * @return paymentCoupon
     */
    public function setTimesRedeemed($timesRedeemed)
    {
        $this->timesRedeemed = $timesRedeemed;
    
        return $this;
    }

    /**
     * Get timesRedeemed
     *
     * @return integer 
     */
    public function getTimesRedeemed()
    {
        return $this->timesRedeemed;
    }
}
