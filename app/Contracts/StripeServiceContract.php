<?php

namespace PCLab\Contracts;

use Stripe\Charge;

interface StripeServiceContract
{
    /**
     * Creates a charge of the given amount for the specified token.
     *
     * @param string $token
     * @param int $amount
     *
     * @return Charge
     */
    public function charge(string $token, int $amount);
}
