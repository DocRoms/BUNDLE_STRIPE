<?php

namespace docroms\Bundle\PaymentBundle\Service;

use Doctrine\ORM\EntityManager;
use docroms\Bundle\PaymentBundle\Classe\genericPaiement;
use docroms\Bundle\PaymentBundle\Classe\paypalPaiment;
use docroms\Bundle\PaymentBundle\Classe\stripePaiement;
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