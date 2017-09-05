<?php

namespace PCLab\Services;

use PCLab\Contracts\StripeServiceContract;
use Stripe\Charge;
use Stripe\Stripe;

class StripeService implements StripeServiceContract
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_API_SK'));
    }

    public function charge(string $token, int $amount): Charge
    {
        return Charge::create([
            'amount'      => $amount,
            'currency'    => 'usd',
            'description' => 'Custom rig',
            'source'      => $token,
        ]);
    }
}
