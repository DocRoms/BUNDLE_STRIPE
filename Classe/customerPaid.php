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
    private $_profilePaymentId;

    private $_planId;

    private $_stripeId;

    private $_stripeSubscriptionId;

    private $_isStripeSubscriptionActive;

    private $_paypalId;

    private $_accountType;

    private $_websiteId;

    /**
     * @var array
     */
    private $_bills;


    public function setProfilePaymentId($id){
        $this->_profilePaymentId = $id;
    }

    public function getProfilePaymentId(){
        return $this->_profilePaymentId;
    }

    public function setStripeId($id){
        $this->_stripeId = $id;
    }

    public function setStripeSubscriptionId($id){
        $this->_stripeSubscriptionId = $id;
    }

    public function getStripeSubscriptionId(){
        return $this->_stripeSubscriptionId;
    }

    /**
     * @param $id string
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

    public function getStripeId(){
        return $this->_stripeId;
    }

    public function setPaypalId($id){
        $this->_paypalId = $id;
    }

    public function getPaypalId(){
        return $this->_paypalId;
    }


    public function setPlanlId($id){
        $this->_planId = $id;
    }

    public function getPlanId(){
        return $this->_planId;
    }

    public function setWebsiteId($id){
        $this->_websiteId = $id;
    }

    public function getWebsiteId(){
        return $this->_websiteId;
    }

    public function setAccountType($type){
        $this->_accountType = $type;
    }

    public function getAccountType(){
        return $this->_accountType;
    }

    public function setBills($type){
        $this->_bills = $type;
    }

    public function getBills(){
        return $this->_bills;
    }
}