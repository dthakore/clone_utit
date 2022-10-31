<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Stripe;

class StripeController extends Controller
{
    public function index()
    {
        return view('frontend.orders.billing');
    }

    public function pay(Request $request)
    {

        // Replace with your secret key, found in your Stripe dashboard
        Stripe\Stripe::setApiKey(config('app.STRIPE_SECRET')); 

        function calculateOrderAmount(array $items): int {
            return 499;
        }

        header('Content-Type: application/json');

        try {

            $jsonStr = file_get_contents('php://input');
            $jsonObj = json_decode($jsonStr);

            $paymentIntent = Stripe\PaymentIntent::create([
                'amount' => calculateOrderAmount($jsonObj->items),
                'currency' => 'eur', // Replace with your country's primary currency
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                // Remove if you don't want to send automatic email receipts after successful payment
                "receipt_email" => $request->email 
            ]);

            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }
}
