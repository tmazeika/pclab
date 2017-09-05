<?php

namespace PCLab\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PCLab\Compatibility\Contracts\SelectionContract;
use PCLab\Contracts\StripeServiceContract;
use PCLab\Mail\OrderSubmitted;
use PCLab\Models\ComponentChild;

class CheckoutController extends Controller
{
    public function index(SelectionContract $selection)
    {
        return view('checkout.index', ['totalPrice' => $this->getTotalPrice($selection)]);
    }

    public function pay(Request $request, SelectionContract $selection, StripeServiceContract $stripeService)
    {
        $charge = $stripeService->charge($request->get('stripeToken'), $this->getTotalPrice($selection));
        $mailto  = $request->get('stripeShippingName') . PHP_EOL;
        $mailto .= $request->get('stripeShippingAddressLine1') . PHP_EOL;
        $mailto .= $request->get('stripeShippingAddressCity') . ', ' . $request->get('stripeShippingAddressState') . ' ' . $request->get('stripeShippingAddressZip') . PHP_EOL;
        $mailto .= $request->get('stripeShippingAddressCountry') . PHP_EOL;

        Mail::to('mazeika.tj@gmail.com')->send(new OrderSubmitted($selection, $mailto));

        return 'Your order will be at your doorstep in the next 12.3 seconds!';
    }

    private function getTotalPrice(SelectionContract $selection): int
    {
        return $totalPrice = $selection->getAll()->sum(function (ComponentChild $component) {
            return $component->parent->price;
        });
    }
}
