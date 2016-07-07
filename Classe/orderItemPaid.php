<?php
/**
 * Created by PhpStorm.
 * User: docro
 * Date: 07/07/2016
 * Time: 12:14
 */

namespace docroms\Bundle\PaymentBundle\Classe;


class orderItemPaid
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
     * @var int
     */
    private $_quantity;

}