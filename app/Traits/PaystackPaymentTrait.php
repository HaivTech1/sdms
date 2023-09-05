<?php

namespace App\Traits;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait PaystackPaymentTrait
{
    public function makeOneTimePayment(Request $request)
    {
        $data = Setting::where(['key' => 'paystack'])->first();
        $paystack = json_decode($data['value'], true);
        $secretKey = env('PAYSTACK_SECRET_KEY', $paystack['secretKey']);
        $payload = [
            'email' => $request->input('email'),
            'amount' => $request->input('amount'), 
            'reference' => time(),
            'currency' => $request->currency,
            'callback_url' => route('payment.order.callback'),
            'metadata' => $request->metadata,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->post('https://api.paystack.co/transaction/initialize', $payload);

        if ($response->successful()) {
            $authorizationUrl = $response['data']['authorization_url'];
            return redirect($authorizationUrl);
        } else {
            $errorMessage = $response['message'];
            $notification = [
                'messege' => $errorMessage,
                'alert-type' => 'error',
                'button' => 'Okay',
                'title' => 'Transactional Error'
            ];
            return back()->with($notification);
        }
    }

    private function verifyPayment($transactionRef)
    {
        $data = Setting::where(['key' => 'paystack'])->first();
        $paystack = json_decode($data['value'], true);
        $secretKey = env('PAYSTACK_SECRET_KEY', $paystack['secretKey']);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
        ])->get("https://api.paystack.co/transaction/verify/{$transactionRef}");

        if ($response->successful()) {
            $data = $response['data'];
            $status = $data['status'];
            return [
                'status' => $status,
                'data' => $data
            ];
        }
        return null;
    }
}
