<?php
/**
 * Created by PhpStorm.
 * User: docro
 * Date: 07/07/2016
 * Time: 12:14
 */

namespace Payment\PaymentBundle\Classe;


class orderPaid
{
    /**
     * @var string
     */
    private $_stripeId;

    /**
     * @var int
     */
    private $_amount;

    /**
     * @var string
     */
    private $_curency;

    /**
     * @var array()
     */
    private $_itemList;
    
}