<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Mail\SendMidtermMail;
use App\Events\Student\PaymentEvent;
use App\Mail\Student\NewPaymentMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{

    public function generateToken(Request $request)
    {
        $paystack = new Paystack();
        $paystack->initialize('sk_test_ba1a48170406832ff34b737b4571e39f76ee8326');

        $token = $paystack->genTranxRef();
        $authorization_url = $paystack->getAuthorizationUrl();

        return response()->json([
            'token' => $token,
            'authorization_url' => $authorization_url,
        ]);
    }

    public function redirectToGateway(Request $request)
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            $notification = array(
                'messege'     => 'The paystack token has expired. Please refresh the page and try again.!',
                'alert-type'    => 'error',
                'button' => 'Okay',
                'title' => 'Expired Token',
            );
            return redirect()->back()->with($notification);
        }
    }

    public function handleGatewayCallback()
    {
        try {
            $paymentDetails = Paystack::getPaymentData();

            // dd($paymentDetails);
            $user = User::findOrFail($paymentDetails['data']['metadata']['author_id']);
            $amount =  $paymentDetails['data']['amount'] / 100;
            $balance = $paymentDetails['data']['metadata']['payable'] - $amount;
            $paymentType = ($amount == $paymentDetails['data']['metadata']['payable']) ? 'full' : 'partial';
            $paidBy = Student::findOrFail($paymentDetails['data']['metadata']['student_uuid']);
    
            $check = paymentCheck($paymentDetails['data']['id'], $paymentDetails['data']['reference'] );
    
            if(!$check){
                if (!$paymentDetails['data']['metadata']['old_payment_id']) {
                    $payment = new Payment();
                    $payment->paid_by = $paidBy->last_name . ' ' . $paidBy->first_name. ' ' . $paidBy->other_name;
                    $payment->student_uuid = $paymentDetails['data']['metadata']['student_uuid'];
                    $payment->amount = $amount;
                    $payment->initial = $paymentDetails['data']['metadata']['initial'];
                    $payment->payable = $paymentDetails['data']['metadata']['payable'];
                    $payment->balance = $balance;
                    $payment->type = $paymentType;
                    $payment->term_id = $paymentDetails['data']['metadata']['term_id'];
                    $payment->period_id = period('id');
                    $payment->method = $paymentDetails['data']['channel'];
                    $payment->trans_id = $paymentDetails['data']['id'];
                    $payment->ref_id= $paymentDetails['data']['reference'];
                    $payment->authoredBy($user);
                    $payment->save();

                    if($payment->type === 'partial'){
                        $array = [ 
                            'grade_id' => $paidBy->grade->id(), 
                            'student_id' => $paymentDetails['data']['metadata']['student_uuid'], 
                            'term_id' => $paymentDetails['data']['metadata']['term_id'], 
                            'period_id' => period('id'), 
                            'outstanding' => $balance
                        ];
                        $paidBy->update([
                            'outstanding' => $array,
                        ]);
                    }else{
                        $paidBy->update([
                            'outstanding' => Null,
                        ]);
                    }
                }else{
                    $payment = Payment::findOrFail($paymentDetails['data']['metadata']['old_payment_id']);
                    $bal = $paymentDetails['data']['metadata']['old_payment'] + $amount;
                    $payment->update([
                        'amount' => $paymentDetails['data']['metadata']['old_payment'] + $amount, 
                        'type' => 'full', 
                        'balance' => $paymentDetails['data']['metadata']['payable'] - $bal,
                        'trans_id' => $paymentDetails['data']['id'],
                        'ref_id' => $paymentDetails['data']['reference']
                    ]);
                    $paidBy->update([
                        'outstanding' => Null,
                    ]);
                }

                $bursars = User::where('type', User::BURSAL)->get();

                foreach ($bursars as $bursar) {
                    Mail::to($bursar->email())->send(new NewPaymentMail($payment));
                }

                $name = $paidBy->last_name." ".$paidBy->first_name. " ".$paidBy->other_name;
                $paid = 'NGN' .number_format($payment->amount(), 2);
                $bal = 'NGN' .number_format($payment->balance(), 2);

                $message = "<p>You just made a payment of $paid for $name. Your balance is $bal. Thank you.</p>";
                $subject = 'Payment Confirmation';

                if(isset($paidBy->mother)){
                    Mail::to($paidBy->mother->email())->send(new SendMidtermMail($message, $subject));
                }elseif(isset($paidBy->father)){
                    Mail::to($paidBy->father->email())->send(new SendMidtermMail($message, $subject));
                }else{
                    Mail::to($paidBy->guardian->email())->send(new SendMidtermMail($message, $subject));
                }

                return view('student.receipt', ['payment' => $payment]);
            }
            return view('student.receipt',['payment' => $check]);
        } catch (\Exception $th) {
            $notification = array(
                'message' => $th->getMessage(),
                'alert-type' => 'error',
                'button' => 'Okay!',
                'title' => 'Failed'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function receipt($payment)
    {
        $check = Payment::findOrFail($payment);
        return view('student.receipt',[
            'payment' => $check
        ]);
    }
}
