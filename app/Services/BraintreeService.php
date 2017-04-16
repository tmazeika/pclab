<?php

namespace PCForge\Services;

use Braintree;
use PCForge\Contracts\BraintreeServiceContract;

class BraintreeService implements BraintreeServiceContract
{
    /**
     * BraintreeService constructor.
     */
    public function __construct()
    {
        Braintree\Configuration::environment(env('BRAINTREE_ENVIRONMENT', 'sandbox'));
        Braintree\Configuration::merchantId(env('BRAINTREE_MERCHANT_ID'));
        Braintree\Configuration::publicKey(env('BRAINTREE_PUBLIC_KEY'));
        Braintree\Configuration::privateKey(env('BRAINTREE_PRIVATE_KEY'));
    }

    public function generateClientToken(): string
    {
        return Braintree\ClientToken::generate();
    }

    public function performTransaction(int $price, string $nonce)
    {
        //
    }
}
