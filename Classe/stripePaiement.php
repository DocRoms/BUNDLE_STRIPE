<?php

namespace docroms\Bundle\PaymentBundle\Classe;

/**
 * Created by PhpStorm.
 * User: docro
 * Date: 31/05/2016
 * Time: 13:35
 */


use Doctrine\ORM\EntityManager;
use docroms\Bundle\PaymentBundle\Entity\paymentCoupon;
use docroms\Bundle\PaymentBundle\Entity\paymentPlan;
use docroms\Bundle\PaymentBundle\paymentProfile;
use docroms\Bundle\PaymentBundle\paymentTransaction;
use Stripe\Coupon;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\Plan;
use Symfony\Component\Security\Acl\Exception\Exception;

class stripePaiement implements genericPaiement
{
    /**
     * @var array mandatory fields
     */
    private $_mandatoryFields= null;

    /**
     * @var Customer
     */
    protected $_customer = null;

    /**
     * @var Subscription
     */
    protected $_subscription = null;

    /**
     * @var EntityManager
     */
    protected $_entityManager = null;


    /**
     * @param EntityManager $entityManager
     * @param $mandatoryFields
     */
    public function init($entityManager, $mandatoryFields)
    {
        $this->_mandatoryFields = $mandatoryFields;
        $this->_entityManager = $entityManager;

        // Set all values.
        Stripe::setApiKey($this->_mandatoryFields['stripeTestSecretKey']);
    }


    /**
     * @param int $customerId
     * @return customerPaid
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function createOrGetCustomer($customerId)
    {
        //Check if isset On DataBase.
        $repo = $this->_entityManager->getRepository('PaymentBundle:paymentProfile');
        $qb = $repo->createQueryBuilder('pp')
            ->where('pp.profileId = :profileId')
            ->setParameter('profileId',$customerId);

        $result = $qb->getQuery()->getOneOrNullResult();

        // Create stripe user and Save on DataBase.
        if (is_null($result)){
            // Create Stripe User
            $stripeArgs = array(
                'description' => 'Création du customer stripe pour l\'id ' . $customerId,
                'source' => $this->_mandatoryFields['stripeToken']
            );
            $this->_customer = Customer::create($stripeArgs);

            // Save on DataBase
            $profilePaid = new paymentProfile();
            $profilePaid->setProfileId($customerId);
            $profilePaid->setStripeId($this->_customer->id);
            try {
                $this->_entityManager->persist($profilePaid);
                $this->_entityManager->flush();
            }catch(\Exception $e){
                var_dump($e->getMessage());
            }
        }

        // Retrived on DataBase
        $repo = $this->_entityManager->getRepository('PaymentBundle:paymentProfile');
        $qb = $repo->createQueryBuilder('pp')
            ->where('pp.profileId = :profileId')
            ->setParameter('profileId',$customerId);

        $result = $qb->getQuery()->getOneOrNullResult();

        // Return the DataBase result.
        $custObject = new customerPaid();
        $custObject->setWebsiteId($customerId);
        $custObject->setStripeId($result->getStripeId());
        $custObject->setProfilePaymentId($result->getId());

        return $custObject;
    }

    /**
     * @return mixed
     */
    public function createOrGetCoupon($args, $id)
    {
        if (!is_null($args))
        {
            $stripeArgs = $args;
            unset($stripeArgs['description']);

            $repo = $this->_entityManager->getRepository('PaymentBundle:paymentCoupon');
            $qb = $repo->createQueryBuilder('pc')
                ->where('pc.amountOff = :amountOff')
                ->orWhere('pc.prcentOff = :percentOff')
                ->setParameters(
                    array('amountOff'=> $args['amount_off'],
                        'percentOff'=> $args['percent_off']
                    ));

            $result = $qb->getQuery()->getOneOrNullResult();

            if (is_null($result))
            {
                $coupon = Coupon::create($stripeArgs);

                var_dump($coupon);
                
                $couponPaid = new paymentCoupon();
                $couponPaid->setAmountOff($args['amount_off']);
                $couponPaid->setPrcentOff($args['percent_off']);

                try {
                    $this->_entityManager->persist($couponPaid);
                    $this->_entityManager->flush();
                }catch(\Exception $e){
                    var_dump($e->getMessage());
                }
            }else{
                throw new Exception('THIS COUPON ALREADY EXIST ON DATABASE...');
            }
        }
    }

    public function createOrGetPlan($args = null, $id = null)
    {
        if (!is_null($args))
        {
            $stripeArgs = $args;
            unset($stripeArgs['description']);

            $repo = $this->_entityManager->getRepository('PaymentBundle:paymentPlan');
            $qb = $repo->createQueryBuilder('pp')
                ->where('pp.amount = :amount')
                ->andWhere('pp.curency = :curency')
                ->andWhere('pp.intervalPaid = :interval')
                ->setParameters(
                    array('amount'=> $args['amount'],
                        'curency'=> $args['currency'],
                        'interval'=> $args['interval']
                        ));

            $result = $qb->getQuery()->getOneOrNullResult();

            if (is_null($result))
            {
                $plan = Plan::create($stripeArgs);

                $paymentPaid = new paymentPlan();
                $paymentPaid->setAmount($args['amount']);
                $paymentPaid->setCurency($args['currency']);
                $paymentPaid->setDescription($args['description']);
                $paymentPaid->setStripeId($args['id']);
                $paymentPaid->setIntervalPaid($args['interval']);
                $paymentPaid->setNam($args['name']);

                try {
                    $this->_entityManager->persist($paymentPaid);
                    $this->_entityManager->flush();
                }catch(\Exception $e){
                    var_dump($e->getMessage());
                }
            }else{
                throw new Exception('THIS PLAN ALREADY EXIST ON DATABASE...');
            }
        }

        // Get an return database entity
        $repo = $this->_entityManager->getRepository('PaymentBundle:paymentPlan');

        if (is_null($args) && !is_null($id)){
            $qb = $repo->createQueryBuilder('pp')
                ->where('pp.stripeId = :stripeId')
                ->setParameters(
                    array('stripeId'=> $id
                ));
        }else{
            $qb = $repo->createQueryBuilder('pp')
                ->where('pp.amount = :amount')
                ->andWhere('pp.curency = :curency')
                ->andWhere('pp.intervalPaid = :interval')
                ->setParameters(
                    array('amount'=> $args['amount'],
                        'curency'=> $args['currency'],
                        'interval'=> $args['interval']
                    ));
        }

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $planId
     * @param customerPaid $customer
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function createSubscriptionByPlan($planId, $customer)
    {
        //Check if isset On DataBase.
        $repo = $this->_entityManager->getRepository('PaymentBundle:paymentTransaction');
        $qb = $repo->createQueryBuilder('pt')
            ->where('pt.planId = :planId')
            ->andWhere('pt.profilePayementId = :profilePaymentId')
            ->setParameters(
                array('planId' => $planId,
                    'profilePaymentId' => $customer->getProfilePaymentId() ));

        $result = $qb->getQuery()->getOneOrNullResult();

        // Create Stripe Customer and Save On Database
        if (is_null($result)){
            // Create Stripe Customer.
            $this->_subscription  = Subscription::create(array(
                "customer" => $customer->getStripeId(),
                "plan" => $planId
            ));

            // Save Customer on Database
            $transactionPaid = new paymentTransaction();
            $transactionPaid->setProfilePayementId($customer->getProfilePaymentId());
            $transactionPaid->setPlanId($planId);

            try {
                $this->_entityManager->persist($transactionPaid);
                $this->_entityManager->flush();
            }
            catch(\Exception $e){
                var_dump($e->getMessage());
            }
        }else{
            throw new Exception('ANALYSE SUBSCRIPTION HERE BECAUSE ALREADY EXIST ON DATABASE...');
        }
    }

    /**
     * @return mixed
     */
    public function cancelSubscriptionByCustomerAndPlan($customerId, $planId)
    {
        echo $this->_subscription->id;

        Subscription::retrieve("sub_8lKhJYIQXK43lf");
        $lol = $this->_subscription->cancel();

        var_dump($lol);
    }

    /**
     * @return Customer
     */
    public function getCustomer(){
        return $this->_customer;
    }

    /**
     * @return array
     */
    public function getMandatoryFields()
    {
        return $this->_mandatoryFields;
    }

    /**
     * @return mixed
     */
    public function createOrGetOrder($args, $id)
    {
        // TODO: Implement createOrGetOrder() method.
    }
}