@extends('layouts.master')

@section('title', 'Checkout')

@section('main')
    <form method="POST" action="{{ url('lab/checkout') }}">
        {{ csrf_field() }}

        <script
                id="checkout-button"
                class="stripe-button"
                src="https://checkout.stripe.com/checkout.js"
                data-locale="auto"
                data-key="{{ env('STRIPE_API_PK') }}"
                data-label="Checkout"
                data-bitcoin="true"
                data-name="PCLab"
                data-description="Custom rigs for perfectionists."
                data-image="http://pclab.io/pclab_flask.svg"
                data-amount="{{ $totalPrice }}"
                data-currency="usd"
                data-zip-code="true"
                data-shipping-address="true">
        </script>
    </form>
@endsection
