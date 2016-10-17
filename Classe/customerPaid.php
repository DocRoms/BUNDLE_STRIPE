<?php
/**
 * Created by PhpStorm.
 * User: Romuald
 * Date: 06/07/2016
 * Time: 15:48
 */

namespace docroms\Bundle\PaymentBundle\Classe;


class customerPaid
{
    /**
     * @var string
     */
    private $_profilePaymentId;

    /**
     * @var string
     */
    private $_planId;

    /**
     * @var string
     */
    private $_stripeId;

    /**
     * @var string
     */
    private $_stripeSubscriptionId;

    /**
     * @var boolean
     */
    private $_isStripeSubscriptionActive;

    /**
     * @var string
     */
    private $_paypalId;

    /**
     * @var string
     */
    private $_accountType;

    /**
     * @var string
     */
    private $_websiteId;

    /**
     * @var array
     */
    private $_bills;


    /**
     * @param $id string
     */
    public function setProfilePaymentId($id){
        $this->_profilePaymentId = $id;
    }

    /**
     * @return string
     */
    public function getProfilePaymentId(){
        return $this->_profilePaymentId;
    }

    /**
     * @param $id string
     */
    public function setStripeId($id){
        $this->_stripeId = $id;
    }

    /**
     * @param $id string
     */
    public function setStripeSubscriptionId($id){
        $this->_stripeSubscriptionId = $id;
    }

    /**
     * @return string
     */
    public function getStripeSubscriptionId(){
        return $this->_stripeSubscriptionId;
    }

    /**
     * @param $type string
     */
    public function setIsStripeSubscriptionActive($type){

        $this->_accountType = $type;

        $this->_isStripeSubscriptionActive = false;

        if (strtolower($type) == 'active'
            || strtolower($type) == 'trialing'){
            $this->_isStripeSubscriptionActive = true;
        }
    }

    /**
     * @return boolean
     */
    public function isStripeSubscriptionActive(){
        return $this->_isStripeSubscriptionActive;
    }

    /**
     * @return string
     */
    public function getStripeId(){
        return $this->_stripeId;
    }

    /**
     * @param $id string
     */
    public function setPaypalId($id){
        $this->_paypalId = $id;
    }

    /**
     * @return string
     */
    public function getPaypalId(){
        return $this->_paypalId;
    }

    /**
     * @param $id string
     */
    public function setPlanlId($id){
        $this->_planId = $id;
    }

    /**
     * @return string
     */
    public function getPlanId(){
        return $this->_planId;
    }

    /**
     * @param $id string
     */
    public function setWebsiteId($id){
        $this->_websiteId = $id;
    }

    /**
     * @return string
     */
    public function getWebsiteId(){
        return $this->_websiteId;
    }

    /**
     * @param $type string
     */
    public function setAccountType($type){
        $this->_accountType = $type;
    }

    /**
     * @return string
     */
    public function getAccountType(){
        return $this->_accountType;
    }

    /**
     * @param $type string
     */
    public function setBills($type){
        $this->_bills = $type;
    }

    /**
     * @return array
     */
    public function getBills(){
        return $this->_bills;
    }
}