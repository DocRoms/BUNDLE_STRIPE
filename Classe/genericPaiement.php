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
     * @param $planId
     * @param $customer customerPaid
     * @return customerPaid
     */
    public function createOrGetSubscriptionByPlan($planId, $customer);

    /**
     * @param $customer customerPaid
     * @param $planId
     * @return customerPaid
     */
    public function cancelSubscriptionByCustomerAndPlan($customer);

    /**
     * @param $customer customerPaid
     * @param $planId
     * @return customerPaid
     */
    public function updateSubscriptionByCustomerAndPlan($customer, $planId);

    /**
     * @param $start \DateTime
     * @param $end \DateTime
     * @return mixed
     */
    public function getMonthlyPayemntByPeriod($start, $end);

    /**
     * @param $start \DateTime
     * @param $end \DateTime
     * @return mixed
     */
    public function getYearlyPayemntByPeriod($start, $end);

    /**
     * @param $args
     * @return customerPaid
     */
    public function createOrGetCustomer($args);

    /**
     * @param $customer customerPaid
     * @param $args array
     * @return customerPaid
     */
    public function updateCustomer($customer);

    /**
     * @return mixed
     */
    public function getCustomer();

    /**
     * @return array
     */
    public function getMandatoryFields();
}