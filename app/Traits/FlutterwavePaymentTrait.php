<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

trait FlutterwavePaymentTrait
{
    /**
     * Make a one-time payment using Flutterwave API.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeOneTimePayment(Request $request)
    {
        $secretKey = env('FLW_SECRET_KEY');
        $payload = [
            'tx_ref' => time(),
            'amount' => $request->input('amount'),
            'currency' => 'NGN',
            'redirect_url' => route('payment.callback'),
            'payment_options' => 'card',
            'customer' => [
                'email' => $request->input('email'),
                'name' => $request->input('name'),
            ],
            'customizations' => [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ],
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $secretKey,
        ])->post('https://api.flutterwave.com/v3/payments', $payload);

        if ($response->successful()) {
            $paymentUrl = $response['data']['link'];
            return redirect($paymentUrl);
        } else {
            $errorMessage = $response['message'];
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Charge recurring payments using Flutterwave API.
     *
     * @param User $user
     * @param float $amount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function chargeRecurringPayment(User $user, $amount)
    {
        $secretKey = env('FLW_SECRET_KEY');
        $token = $user->payment_token;
        $payload = [
            'amount' => $amount,
            'currency' => 'NGN',
            'token' => $token,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $secretKey,
        ])->post('https://api.flutterwave.com/v3/payments/tokenized/charge', $payload);

        if ($response->successful()) {
            return redirect()->route('payment.success');
        } else {
            $errorMessage = $response['message'];
            return redirect()->route('payment.failure')->with('error', $errorMessage);
        }
    }

    /**
     * Handle the payment callback for one-time payment or recurring payment.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function paymentCallback(Request $request)
    {
        $transactionRef = $request->input('tx_ref');
        $status = $request->input('status');

        if ($status === 'successful') {
            return view('payment.success');
        } else {
            return view('payment.failure');
        }
    }
}
