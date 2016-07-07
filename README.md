# paymentBundle
Please do not use this Bundle Yet. ^^ 

This Bundle is a test Bundle for Stripe integration (and paypal)

## How to install ?
### composer.json
Add this line : <br>
<code>"doc-roms/payment": "~0.0.1"</code><br>
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
