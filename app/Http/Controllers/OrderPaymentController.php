<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Mail\Messaging\SendMail;
use Illuminate\Support\Facades\DB;
use App\Traits\PaystackPaymentTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Traits\NotifiableParentsTrait;

class OrderPaymentController extends Controller
{
    use PaystackPaymentTrait;

    public function makePayment(Request $request)
    {
        return $this->makeOneTimePayment($request);
    }

    public function handlePaymentCallback(Request $request)
    {
        $transactionRef = $request->input('reference');
        $status = $this->verifyPayment($transactionRef);
    
        if ($status['status'] === 'success') {
            return $this->onPaymentSuccess($status['data']);
        } else {
            return $this->onPaymentFailure($request);
        }
    }

    protected function onPaymentSuccess($paymentData)
    {
        try {
            DB::transaction(function() use ($paymentData) {
                $userId = $paymentData['metadata']['user_id'];
                $author = User::findOrFail($userId);
                $name = $author->student->lastName() . ' '. $author->student->firstName();
                $amount = $paymentData['amount'];
                    
                $cartItems = $paymentData['metadata']['cartItems'];
                $ref = $paymentData['reference'];

                $order = new Order([
                    'user_id' => $userId,
                    'items' => $cartItems,
                    'paid' => $amount,
                    'trxref' => $ref,
                    'status' => 1
                ]);
                $order->save();

                // foreach ($cartItems as $key => $item) {
                //     $cart = Cart::findOrFail($item['id']);
                //     $cart->delete();
                // }

                // $message = "<p>Your order has been placed successfully. Please proceed to the school for pick up.</p>";
                // $subject = "Order Purchased successfully";
                // NotifiableParentsTrait::notifyParents($author->student, $message, $subject);

                $admins = User::where('type', User::ADMIN)->get();
                foreach ($admins as $admin) {
                    $message = "
                        <p>A new order has just been made by <strong>$name</strong>.</p>
                        <p>Please check your dashboard to review the purchase.</p>
                        
                    ";
                    $subject = 'New Product Purchase';
                    Mail::to($admin->email())->send(new SendMail($message, $subject));
                }
                     
            });
 
            $notification = ([
                 'messege' => 'Order completed successfully! you will receive an email notification soon!',
                 'alert-type' => 'success',
                 'button' => 'Okay',
                 'title' => 'Order completed',
            ]);
       
            return redirect()->to('order.user.orders')->with($notification);
            
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

    protected function onPaymentFailure(Request $request)
    {
        return redirect()->route('payment.failure');
    }

}