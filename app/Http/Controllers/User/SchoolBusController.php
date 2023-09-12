<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\PaystackPaymentTrait;
use Illuminate\Support\Facades\Validator;
use Unicodeveloper\Paystack\Facades\Paystack;

class SchoolBusController extends Controller
{
    use PaystackPaymentTrait;
    
    public function index()
    {
        return view('student.bus.index');
    }

    public function makePayment(Request $request)
    {
        return $this->makeOneTimePayment($request);
    }

    public function callback(Request $request)
    {
        return $this->paymentCallback($request);
    }
    

    public function redirectToGateway(Request $request)
    {
        $data = json_decode($request->metadata, true);
        $status = $data['status'];

        try {
            if ($status === 'new_payment') {
            
                $validator = Validator::make($request->all(), [
                    'metadata' => 'required|json',
                    'payment_type' => 'required|in:full,partial',
                ], [
                    'payment_type.required' => 'The payment type is required.',
                    'payment_type.in' => 'Invalid payment type selected.',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    return Paystack::getAuthorizationUrl()->redirectNow();
                }
            }else{
                return Paystack::getAuthorizationUrl()->redirectNow();
            }
        } catch (\Exception $e) {
            $notification = [
                'messege' => 'The paystack token has expired. Please refresh the page and try again.!',
                'alert-type' => 'error',
                'button' => 'Okay',
                'title' => 'Expired Token',
            ];
            return redirect()->back()->with($notification);
        }
    }

    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        try {
           DB::transaction(function() use ($paymentDetails) {
                if ($paymentDetails['status']) {

                    $paymentStatus = $paymentDetails['data']['metadata']['status'];
                    $userId = $paymentDetails['data']['metadata']['user_id'];
                    $author = User::findOrFail($userId);
                    $name = $author->lastName() . ' '. $author->firstName();
                    $amount = $paymentDetails['data']['amount'] / 100;
                    

                    if ($paymentStatus === 'new_payment') {

                        $cartItems = $paymentDetails['data']['metadata']['cartItems'];
                        $ref = $paymentDetails['data']['reference'];
                        $type = $paymentDetails['data']['metadata']['payment_type'];
                        $balance = $paymentDetails['data']['metadata']['price'] - $amount;
                        $month = $paymentDetails['data']['metadata']['duration'];

                        $newArray = [];
                        foreach ($cartItems as $item) {
                            $newArray[] = [
                                'id' => $item['id'],
                                'course_id' => $item['course_id'],
                                'author_id' => $item['author_id'],
                            ];
                        }

                        $order = new Order([
                            'author_id' => $userId,
                            'items' => $newArray,
                            'paid' => $amount,
                            'balance' => $balance,
                            'trxref' => $ref,
                            'type' => $type,
                        ]);

                        if ($order->save()) {

                            if ($type === 'partial') {

                                $dates = [];
                                $currentDate = Carbon::now();

                                for ($i = 1; $i <= $month; $i++) {
                                    $nextDate = $currentDate->copy()->addMonths($i);
                                    $dates[] = $nextDate->format('Y-m-d');
                                }

                                $debtor = new Debtor([
                                    'order_id' => $order->id(),
                                    'balance' => $balance,
                                    'duration' => $month,
                                    'payment_dates' => $dates
                                ]);
                                $debtor->authoredBy(auth()->user());
                                $debtor->save();

                                foreach ($debtor->payment_dates as $date) {
                                    $payment = new Payment([
                                        'date' => $date,
                                        'debtor_id' => $debtor->id()
                                    ]);
                                    $payment->authoredBy(auth()->user());
                                    $payment->save();
                                }

                                $formattedAmount = number_format($amount, 2);
                                $formattedBalance = number_format($balance, 2);

                                $message = "
                                    <p>Thank you for purchasing our course. You are getting this email notification because you have decided to spread your payment method for $month months.</p>
                                    <p>You have made a payment of #$formattedAmount, left to balance up with #$formattedBalance.</p>
                                    <p>Please be informed, certificte will only be issued to customers with complete payment.</p>
                                    <p>We look forward to your complete payment. Do enjoy your course.</p>
                                    
                                ";
                                $subject = 'Advance payment notification';
                                Mail::to($debtor->author()->email())->send(new SendMail($message, $subject));
                            }

                            foreach ($cartItems as $key => $item) {
                                $cart = Cart::findOrFail($item['id']);
                                $cart->delete();
                            }

                            $refer = Referral::where('referred_id', $author->id())->first();
                            if ($refer) {
                                $referredBy = User::findOrFail($refer->referrer_id);
                                event(new UserReferred($referredBy, $author));
                            }
        
                            $message = "<p>Thank you for purchasing our course. We have recieved your payment and your workspace will be prepared. Please look out for a new email notification from us.</p>";
                            $subject = "Course Purchase successfully";
                            Mail::to($author->email())->send(new SendMail($message, $subject));
        
                            $admins = User::where('type', User::ADMIN)->get();
                            foreach ($admins as $admin) {
                                $message = "
                                    <p>A new course purchase has just been made by <strong>$name</strong>.</p>
                                    <p>Please check your dashboard to review the purchase.</p>
                                    
                                ";
                                $subject = 'New Course Purchase';
                                Mail::to($admin->email())->send(new SendMail($message, $subject));
                            }
                        }
                    }else{

                        $paymentId = $paymentDetails['data']['metadata']['payment_id'];
                        $payment = Payment::findOrFail($paymentId);
                        $payment->update([
                            'status' => true,
                        ]);

                        $orderId = $paymentDetails['data']['metadata']['order_id'];
                        $order = Order::findOrFail($orderId);
                        $payments = $order->debtor->payments;

                        $allPaymentsTrue = true;

                        foreach ($payments as $payment) {
                            if (!$payment->status) {
                                $allPaymentsTrue = false;
                                break;
                            }
                        }

                        if ($allPaymentsTrue) {
                            $order->update([
                                'type' => 'full',
                                'balance' => 0
                            ]);

                            $order->debtor->update([
                                'status' => true,
                            ]);

                            $subject = "Payment recieved successfully";
                            $message = "
                                <p>Thank you for choosing to learn with us. Your advances are now settled.</p>
                                <p> Do enjoy your studies.</p>
                            ";
    
                            Mail::to($author->email())->send(new SendMail($message, $subject));
                        } else {
                            $order->update([
                                'balance' => $order->balance - $amount,
                            ]);
                            $next = Payment::findOrFail($paymentId + 1);
                            $nextPay = balanceCalculator($next->debtor->balance, 2);

                            $subject = "Payment recieved successfully";
                            $message = "
                                <p>We are glad to inform you that we've receive a payment of #$amount from you for your course purchase. </p>
                                <p>Your next due date payment is $next->date and a sum of #$nextPay</p>
                            ";

                            Mail::to($author->email())->send(new SendMail($message, $subject));
                        }
                    }
                }
           });

           $notification = ([
                'messege' => 'Order completed successfully! you will receive an email notification soon!',
                'alert-type' => 'success',
                'button' => 'Okay',
                'title' => 'Order completed',
            ]);
      
            return redirect()->back()->with($notification);
           
        } catch (\Exception $th) {
            DB::rollback();
            $notification = array(
                'messege' => $th->getMessage(),
                'alert-type' => 'error',
                'button' => 'Okay!',
                'title' => 'Failed'
            );
            return redirect()->back()->with($notification);
        }
    }
}