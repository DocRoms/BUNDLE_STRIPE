<?php

namespace docroms\Bundle\PaymentBundle\Classe;
/**
 * Created by PhpStorm.
 * User: docro
 * Date: 31/05/2016
 * Time: 13:35
 */
interface genericPaiement
{
    /**
     * @param $mandatoryFields
     * @return mixed
     */
    public function init($entityManager, $mandatoryFields);

    /**
     * @return mixed
     */
    public function createOrGetPlan($args, $id);

    /**
     * @return mixed
     */
    public function createOrGetCoupon($args, $id);


    /**
     * @return mixed
     */
    public function createOrGetOrder($args, $id);

    /**
     * @return mixed
     */
    public function createSubscriptionByPlan($planId, $customerId);

    /**
     * @return mixed
     */
    public function cancelSubscriptionByCustomerAndPlan($customerId, $planId);

    /**
     * @param $args
     * @return customerPaid
     */
    public function createOrGetCustomer($args);

    /**
     * @return mixed
     */
    public function getCustomer();

    /**
     * @return array
     */
    public function getMandatoryFields();
}