# paymentBundle
Please do not use this Bundle Yet. ^^ 

This Bundle is a test Bundle for Stripe integration (and paypal)

## How to install ?
### composer.json
Add this line : <br>
<code>"docroms/payment-bundle": "dev-master",</code><br>
### config.json
Add this lines : <br>

<code>payment:</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>paypalMode: sandbox</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>paypalIdentifiant: Id-Paypal</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>paypalUserApi: User-Paypal</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>paypalUserPassApi : Pass-Paypal</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>paypalSignature : Signature-Paypal</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>paypalClientId : ClientId-Paypal</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>paypalSecret : Secret-Paypal</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>stripeTestSecretKey : secretKey-Stripe</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>stripeTestPublishableKey : publishableKey-Stripe</code><br>
    
### AppKernel.php
Add this lines on the Bundles array: <br>
    <code>new \docroms\Bundle\PaymentBundle\PaymentBundle()</code>
    
    
## How to use it?
### On your controller : 
You can just initialize the payment like that : <br>
<code> $genericPaid = $this->get('payment.paiement')</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>->init('stripe')</code><br>
    &nbsp;&nbsp;&nbsp;&nbsp;<code>->getGeneratePay();</code><br>


