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
use docroms\Bundle\PaymentBundle\Entity\paymentProfile;
use docroms\Bundle\PaymentBundle\Entity\paymentTransaction;
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
            if (isset($this->_mandatoryFields['stripeToken']) && isset($this->_mandatoryFields['email'])){
                $stripeArgs = array(
                    'description' => 'Création du customer stripe pour l\'id ' . $customerId,
                    'source' => $this->_mandatoryFields['stripeToken'],
                    'email' => $this->_mandatoryFields['email']
                );
            }else if (isset($this->_mandatoryFields['stripeToken'])){
                $stripeArgs = array(
                    'description' => 'Création du customer stripe pour l\'id ' . $customerId,
                    'source' => $this->_mandatoryFields['stripeToken']
                );
            }else if (isset($this->_mandatoryFields['email'])){
                $stripeArgs = array(
                    'description' => 'Création du customer stripe pour l\'id ' . $customerId,
                    'email' => $this->_mandatoryFields['email']
                );
            }else{
                $stripeArgs = array(
                    'description' => 'Création du customer stripe pour l\'id ' . $customerId
                );
            }

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
            //echo "<br> new ";
            //var_dump($this->_customer);
            //echo "<br>";
        }else{
            $this->_customer =  Customer::retrieve($result->getStripeId());
            //echo "<br> retrive ";
            //echo "<br>";
            //var_dump($this->_customer);
            //echo "<br>";
        }

        // Retrived on DataBase
        $repo = $this->_entityManager->getRepository('PaymentBundle:paymentProfile');
        $qb = $repo->createQueryBuilder('pp')
            ->where('pp.profileId = :profileId')
            ->setParameter('profileId',$customerId);

        $result = $qb->getQuery()->getOneOrNullResult();

        // Todo: Join both request on same request.
        // Retrived on DataBase
        $repoTransaction = $this->_entityManager->getRepository('PaymentBundle:paymentTransaction');
        $qbTransac = $repoTransaction->createQueryBuilder('pt')
            ->where('pt.profilePayementId = :profilePaymentId')
            ->setParameter('profilePaymentId',$result->getId());

        $resultTransac = $qbTransac->getQuery()->getOneOrNullResult();

        // Return the DataBase result.
        $custObject = new customerPaid();
        if (!is_null($resultTransac))
        {
            try {
                $this->_subscription = Subscription::retrieve($resultTransac->getStripeSubscriptionId());
                $custObject->setStripeSubscriptionId($resultTransac->getStripeSubscriptionId());
                $custObject->setPlanlId($resultTransac->getPlanId());
                $array = $this->_subscription->jsonSerialize();
                $custObject->setIsStripeSubscriptionActive($array['status']);
            }catch(\Exception $e){
                $custObject->setIsStripeSubscriptionActive($e->getMessage());
            }
        }
        $custObject->setWebsiteId($customerId);
        $custObject->setStripeId($result->getStripeId());

        $custObject->setProfilePaymentId($result->getId());

        return $custObject;
    }

    /**
     * @param $customer customerPaid
     * @param $args array
     * @return customerPaid
     */
    public function updateCustomer($customer)
    {
        $cu = Customer::retrieve($customer->getStripeId());

        if (isset($this->_mandatoryFields['stripeToken'])) {
            $cu->source = $this->_mandatoryFields['stripeToken']; // obtained with Stripe.js
        }
        if (isset($this->_mandatoryFields['email'])){
            $cu->email = $this->_mandatoryFields['email'];
        }
        $cu->save();
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
    public function createOrGetSubscriptionByPlan($planId, $customer)
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

            //var_dump($this->_subscription);
            // Save Customer on Database
            $transactionPaid = new paymentTransaction();
            $transactionPaid->setProfilePayementId($customer->getProfilePaymentId());
            $transactionPaid->setStripeSubscriptionId($this->_subscription->id);
            $transactionPaid->setPlanId($planId);

            try {
                $this->_entityManager->persist($transactionPaid);
                $this->_entityManager->flush();
            }
            catch(\Exception $e){
                var_dump($e->getMessage());
            }
        }else{
            $repoTransaction = $this->_entityManager->getRepository('PaymentBundle:paymentTransaction');
            $qbTransac = $repoTransaction->createQueryBuilder('pt')
                ->where('pt.profilePayementId = :profilePaymentId')
                ->setParameter('profilePaymentId',$customer->getProfilePaymentId());

            $resultTransac = $qbTransac->getQuery()->getOneOrNullResult();

            $this->_subscription = Subscription::retrieve($resultTransac->getStripeSubscriptionId());
        }

            // Retrived on DataBase
            $repo = $this->_entityManager->getRepository('PaymentBundle:paymentProfile');
            $qb = $repo->createQueryBuilder('pp')
                ->where('pp.profileId = :profileId')
                ->setParameter('profileId',$customer->getWebsiteId());

            $result = $qb->getQuery()->getOneOrNullResult();

            // Todo: Join both request on same request.
            // Retrived on DataBase
            $repoTransaction = $this->_entityManager->getRepository('PaymentBundle:paymentTransaction');
            $qbTransac = $repoTransaction->createQueryBuilder('pt')
                ->where('pt.profilePayementId = :profilePaymentId')
                ->setParameter('profilePaymentId',$result->getId());

            $resultTransac = $qbTransac->getQuery()->getOneOrNullResult();

            // Return the DataBase result.
            $custObject = new customerPaid();
            if (!is_null($resultTransac)){
                $custObject->setStripeSubscriptionId($resultTransac->getStripeSubscriptionId());
                $custObject->setPlanlId($resultTransac->getPlanId());
                $array = $this->_subscription->jsonSerialize();
                $custObject->setIsStripeSubscriptionActive($array['status']);
            }
            $custObject->setWebsiteId($customer->getWebsiteId());
            $custObject->setStripeId($result->getStripeId());

            $custObject->setProfilePaymentId($result->getId());

            return $custObject;

    }

    /**
     * @param $customer customerPaid
     * @param $planId
     * @return customerPaid
     */
    public function updateSubscriptionByCustomerAndPlan($customer, $planId)
    {
        try {
            // Create Stripe Customer.
            $this->_subscription = Subscription::retrieve($customer->getStripeSubscriptionId());
            $this->_subscription->plan = $planId;
            $this->_subscription->save();

        }catch(\Exception $e){
            // Subscription not found. (recreate subscription without trial period
            // Create Stripe Customer.
            $this->_subscription  = Subscription::create(array(
                "customer" => $customer->getStripeId(),
                "plan" => $planId,
                "trial_end" => "now"
            ));

            $repo = $this->_entityManager->getRepository('PaymentBundle:paymentTransaction');
            $qb = $repo->createQueryBuilder('pt')
                ->where('pt.profilePayementId = :profilePaymentId')
                ->setParameters(
                    array('profilePaymentId' => $customer->getProfilePaymentId() ));

            $result = $qb->getQuery()->getOneOrNullResult();

            if (!is_null($result)){
                $result->setStripeSubscriptionId($this->_subscription->id);
                $result->setPlanId($planId);

                $this->_entityManager->persist($result);
                $this->_entityManager->flush();
            }
        }
        
        // Update the plan on DataBase
        //Check if isset On DataBase.
        $repo = $this->_entityManager->getRepository('PaymentBundle:paymentTransaction');
        $qb = $repo->createQueryBuilder('pt')
            ->where('pt.profilePayementId = :profilePaymentId')
            ->setParameters(
                array('profilePaymentId' => $customer->getProfilePaymentId() ));

        $result = $qb->getQuery()->getOneOrNullResult();

        if (!is_null($result)){
            $result->setPlanId($planId);

            $this->_entityManager->persist($result);
            $this->_entityManager->flush();
        }


        $customer->setPlanlId($planId);

        return $customer;
    }

    /**
     * @return mixed
     */
    public function cancelSubscriptionByCustomerAndPlan($customer)
    {
        $this->_subscription = Subscription::retrieve($customer->getStripeSubscriptionId());
        $this->_subscription->cancel(array("at_period_end" => true ));
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