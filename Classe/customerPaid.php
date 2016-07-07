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

    private $_stripeId;

    private $_paypalId;

    private $_websiteId;


    public function setProfilePaymentId($id){
        $this->_profilePaymentId = $id;
    }

    public function getProfilePaymentId(){
        return $this->_profilePaymentId;
    }

    public function setStripeId($id){
        $this->_stripeId = $id;
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

    public function setWebsiteId($id){
        $this->_websiteId = $id;
    }

    public function getWebsiteId(){
        return $this->_websiteId;
    }


}