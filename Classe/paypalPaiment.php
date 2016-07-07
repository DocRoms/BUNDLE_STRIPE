<?php

namespace docroms\Bundle\PaymentBundle\Classe;
/**
 * Created by PhpStorm.
 * User: docro
 * Date: 31/05/2016
 * Time: 13:36
 */


use Doctrine\ORM\EntityManager;
use Payment\PaymentBundle\Classe\customerPaid;
use PayPal\Auth\OAuthTokenCredential;

class paypalPaiment implements genericPaiement
{
    /**
     * @var array mandatiry fields
     */
    private $_mandatoryFields= null;

    /**
     * @param EntityManager $entityManager
     * @param $mandatoryFields
     */
    public function init($entityManager, $mandatoryFields)
    {
        $this->_mandatoryFields = $mandatoryFields;

        $sdkConfig = array(
            "mode" => $this->_mandatoryFields['paypalMode']
        );

        $cred = new OAuthTokenCredential($this->_mandatoryFields['paypalClientId'],$this->_mandatoryFields['paypalSecret'], $sdkConfig);
        // TODO: Implement init() method.
    }

    public function createPlan()
    {
        // TODO: Implement createPlan() method.
    }

    public function createCustomer($args)
    {
        // TODO: Implement createCustomer() method.
    }

    /**
     * @return mixed
     */
    public function createSubscriptionByPlan($planId, $customerId)
    {
        // TODO: Implement createSubscriptionByPlan() method.
    }

    /**
     * @return mixed
     */
    public function cancelSubscriptionByCustomerAndPlan($customerId, $planId)
    {
        // TODO: Implement cancelSubscriptionByCustomerAndPlan() method.
    }

    /**
     * @param $args
     * @return mixed
     */
    public function createOrGetCustomer($args)
    {
        // TODO: Implement createOrGetCustomer() method.
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        // TODO: Implement getCustomer() method.
    }

    /**
     * @return array
     */
    public function getMandatoryFields()
    {
        // TODO: Implement getMandatoryFields() method.
    }

    /**
     * @return mixed
     */
    public function createOrGetCoupon($args, $id)
    {
        // TODO: Implement createOrGetCoupon() method.
    }

    /**
     * @return mixed
     */
    public function createOrGetPlan($args, $id)
    {
        // TODO: Implement createOrGetPlan() method.
    }
}