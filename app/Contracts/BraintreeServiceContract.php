<?php

namespace PCLab\Contracts;

interface BraintreeServiceContract
{
    /**
     * Generates a Braintree client token.
     *
     * @return string
     */
    public function generateClientToken(): string;

    /**
     * Performs a Braintree transaction of the given price and with the nonce supplied by the client.
     *
     * @param int $price
     * @param string $nonce
     *
     * @return mixed
     */
    public function performTransaction(int $price, string $nonce);
}
