<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

trait PaystackPaymentTrait
{
    
    public function makeOneTimePayment(Request $request)
    {
        // Set your Paystack API credentials
        $secretKey = 'YOUR_SECRET_KEY';

        // Prepare the request payload for one-time payment
        $payload = [
            'email' => $request->input('email'),
            'amount' => $request->input('amount') * 100, // Paystack amount is in kobo (multiply by 100 to convert to kobo)
            'reference' => 'YOUR_TRANSACTION_REFERENCE',
            'callback_url' => route('payment.callback'), // Set the callback URL here
        ];

        // Make the API request to Paystack for one-time payment
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->post('https://api.paystack.co/transaction/initialize', $payload);

        // Check the response status
        if ($response->successful()) {
            // Payment request was successful
            // Redirect the user to the Paystack payment page
            $authorizationUrl = $response['data']['authorization_url'];
            return redirect($authorizationUrl);
        } else {
            // Payment request failed
            $errorMessage = $response['message'];
            return back()->with('error', $errorMessage);
        }
    }

   
    public function handlePaymentCallback(Request $request)
    {
        // Verify the payment callback here
        // Retrieve the transaction reference and verify the payment status
        $transactionRef = $request->input('reference');
        $status = $this->verifyPayment($transactionRef);

        if ($status === 'success') {
            // Payment was successful
            return $this->onPaymentSuccess($request);
        } else {
            // Payment was not successful
            return $this->onPaymentFailure($request);
        }
    }

   
    abstract protected function onPaymentSuccess(Request $request);
   
    abstract protected function onPaymentFailure(Request $request);

    private function verifyPayment($transactionRef)
    {
        // Set your Paystack API credentials
        $secretKey = 'YOUR_SECRET_KEY';

        // Make the API request to Paystack for verifying payment status
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->get("https://api.paystack.co/transaction/verify/{$transactionRef}");

        // Check the response status
        if ($response->successful()) {
            $data = $response['data'];
            $status = $data['status'];

            return $status;
        }

        return null;
    }

    public function makeSplitPayment(Request $request)
    {
        // Set your Paystack API credentials
        $secretKey = 'YOUR_SECRET_KEY';

        // Prepare the request payload for split payment
        $payload = [
            'email' => $request->input('email'),
            'amount' => $request->input('amount') * 100, // Paystack amount is in kobo (multiply by 100 to convert to kobo)
            'reference' => 'YOUR_TRANSACTION_REFERENCE',
            'callback_url' => route('payment.callback'), // Set the callback URL here
            'subaccounts' => [
                [
                    'subaccount' => 'SUBACCOUNT1_CODE',
                    'share' => 50, // Percentage share for subaccount 1
                ],
                [
                    'subaccount' => 'SUBACCOUNT2_CODE',
                    'share' => 30, // Percentage share for subaccount 2
                ],
                // Add more subaccounts as needed
            ],
        ];

        // Make the API request to Paystack for split payment
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->post('https://api.paystack.co/transaction/initialize', $payload);

        // Check the response status
        if ($response->successful()) {
            // Payment request was successful
            // Redirect the user to the Paystack payment page
            $authorizationUrl = $response['data']['authorization_url'];
            return redirect($authorizationUrl);
        } else {
            // Payment request failed
            $errorMessage = $response['message'];
            return back()->with('error', $errorMessage);
        }
    }
}
