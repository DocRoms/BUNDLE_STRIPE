<?php

namespace Payment\PaymentBundle\Service;

use Doctrine\ORM\EntityManager;
use Payment\PaymentBundle\Classe\genericPaiement;
use Payment\PaymentBundle\Classe\paypalPaiment;
use Payment\PaymentBundle\Classe\stripePaiement;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Created by PhpStorm.
 * User: docro
 * Date: 01/06/2016
 * Time: 14:03
 */
class Paiement
{
    /**
     * @var null
     */
    private $generatePaid = null;

    /**
     * @var EntityManager
     */
    private $_entityManager;

    /**
     * @var array mandatory fields
     */
    private $mandatoryFields = array(
        'paypalMode' => null,
        'paypalIdentifiant' => null,
        'paypalUserApi' => null,
        'paypalUserPassApi' => null,
        'paypalSignature' => null,
        'paypalClientId' => null,
        'paypalSecret' => null,
        'stripeTestSecretKey' => null,
        'stripeTestPublishableKey' => null
    );

    /**
     * Paiement constructor.
     * @param EntityManager $entityManager
     * @param Container $container
     */
    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->_entityManager = $entityManager;
        //$container->getParameter('');
        foreach ($this->mandatoryFields as $field => $value) {
            $this->mandatoryFields[$field] = $container->getParameter(sprintf('payment.%s', $field));
        }

    }

    /**
     * @param $fields
     * trans_id => x
     * cust_email => xxxxxx@xx.xx
     * @return $this
     */
    public function setOptionnalFields($fields)
    {
        foreach ($fields as $field => $value)
            $this->mandatoryFields[$field] = $value;

        return $this;
    }


    /**
     * @param $typePayment String "paypal" or "stripe"
     * @return $this
     */
    public function init($typePayment){
        switch (strtolower($typePayment)){
            case 'stripe':
                $this->generatePaid = new stripePaiement();
                break;
            case 'paypal':
                $this->generatePaid = new paypalPaiment();
                break;
        }

        if (null === $this->generatePaid){
            throw new ParameterNotFoundException("type Payement parameter is not properly defined");
        }

        $this->generatePaid->init($this->_entityManager, $this->mandatoryFields);

        return $this;
    }

    /**
     * @return genericPaiement
     */
    public function getGeneratePay(){
        return $this->generatePaid;
    }
}