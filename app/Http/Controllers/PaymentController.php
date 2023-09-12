<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\User;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Mail\SendMidtermMail;
use App\Mail\Messaging\SendMail;
use App\Events\Student\PaymentEvent;
use App\Mail\Student\NewPaymentMail;
use App\Traits\PaystackPaymentTrait;
use Illuminate\Support\Facades\Mail;
use App\Traits\NotifiableParentsTrait;
use App\Traits\FlutterwavePaymentTrait;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{

    use PaystackPaymentTrait;
    
     public function makePayment(Request $request)
    {
        return $this->makeOneTimePayment($request);
    }

    public function callback(Request $request)
    {
        return $this->paymentCallback($request);
    }
    
    public function receipt($payment)
    {
        $check = Payment::findOrFail($payment);
        return view('student.receipt',[
            'payment' => $check
        ]);
    }

    public function getStudents(Request $request)
    {
        $email = $request->input('email');

        $students = Student::whereHas('mother', function ($query) use ($email) {
            $query->where('email', $email);
        })->orWhereHas('father', function ($query) use ($email) {
            $query->where('email', $email);
        })->get();

        return response()->json($students);
    }
}