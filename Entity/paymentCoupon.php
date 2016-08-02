<?php

namespace docroms\Bundle\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paymentCoupon
 *
 * @ORM\Table(name="payment_coupon")
 * @ORM\Entity(repositoryClass="docroms\Bundle\PaymentBundle\Repository\paymentCouponRepository")
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
     * @ORM\Column(name="creation", type="datetime", nullable=false)
     */
    private $creation;

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
     * @ORM\Column(name="stripe_id", type="string", length=255)
     */
    private $stripeId;

    /**
     * @var int
     *
     * @ORM\Column(name="times_redeemed", type="integer", nullable=true)
     */
    private $timesRedeemed;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->creation = new \DateTime();
    }

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

    /**
     * Set timesRedeemed
     *
     * @param integer $stripeId
     * @return paymentCoupon
     */
    public function setStripeId($stripeId)
    {
        $this->stripeId = $stripeId;

        return $this;
    }

    /**
     * Get timesRedeemed
     *
     * @return integer
     */
    public function getStripeId()
    {
        return $this->stripeId;
    }

    /**
     * Set timesRedeemed
     *
     * @param \Datetime $creation
     * @return paymentCoupon
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get timesRedeemed
     *
     * @return \Datetime
     */
    public function getCreation()
    {
        return $this->creation;
    }
}
