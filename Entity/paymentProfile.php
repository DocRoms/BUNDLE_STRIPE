<?php

namespace docroms\Bundle\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * paymentProfile
 *
 * @ORM\Table(name="payment_profile")
 * @ORM\Entity(repositoryClass="docroms\Bundle\PaymentBundle\Repository\paymentProfileRepository")
 */
class paymentProfile
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
     * @ORM\Column(name="profile_id", type="integer")
     */
    private $profileId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="stripe_id", type="string", nullable=true)
     */
    private $stripeId;

    /**
     * @var int
     *
     * @ORM\Column(name="paypal_id", type="integer", nullable=true)
     */
    private $paypalId;


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
     * Set profileId
     *
     * @param integer $profileId
     * @return paymentProfile
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    
        return $this;
    }

    /**
     * Get profileId
     *
     * @return integer 
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * Set stripeId
     *
     * @param integer $stripeId
     * @return paymentProfile
     */
    public function setStripeId($stripeId)
    {
        $this->stripeId = $stripeId;
    
        return $this;
    }

    /**
     * Get stripeId
     *
     * @return integer 
     */
    public function getStripeId()
    {
        return $this->stripeId;
    }

    /**
     * Set paypalId
     *
     * @param integer $paypalId
     * @return paymentProfile
     */
    public function setPaypalId($paypalId)
    {
        $this->paypalId = $paypalId;

        return $this;
    }

    /**
     * Get paypalId
     *
     * @return integer
     */
    public function getPaypalId()
    {
        return $this->paypalId;
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return paymentProfile
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
