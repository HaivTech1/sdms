<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->middleware(['auth']);
    }

    public function redirectToGateway(Request $request)
    {
        dd($request);
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }
    }

    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        dd($paymentDetails);
        $user = User::findOrFail($paymentDetails['data']['metadata']['author_id']);

        $payment = new Payment();
        $payment->student_uuid = $paymentDetails['data']['metadata']['student_uuid'];
        $payment->amount = $paymentDetails['data']['amount'];
        $payment->payable = $paymentDetails['data']['metadata']['payable'];
        $payment->balance = $paymentDetails['data']['payable'];
        $payment->type = $paymentDetails['data']['type'];
        $payment->term_id = $paymentDetails['data']['metadata']['term_id'];
        $payment->period_id = period('id');
        $payment->trans_id = $paymentDetails['data']['id'];
        $payment->ref_id= $paymentDetails['data']['reference'];
        $payment->status = 1;
        $payment->authoredBy($user);
        $payment->save();

        event(new PaymentWasMade($payment));
  
        $notification = array(
            'messege'     => 'Transaction is Successfull!',
            'alert-type'    => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
