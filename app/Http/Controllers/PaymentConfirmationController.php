<?php

namespace App\Http\Controllers;

use App\Mail\PaymentConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentConfirmationController extends Controller
{
    public function paymentDetailsReceived(Request $request)
    {
        $senderName  = $request->input('name');
        $senderEmail = $request->input('email');

        $send = Mail::to($senderEmail, $senderName)->send(new PaymentConfirmation([
            'name'        => $request->input('name'),
            'subject'     => $request->input('subject'),
            'email'       => $request->input('email'),
            'transaction' => $request->input('transaction'),
            'value'       => $request->input('value'),
            'description' => $request->input('description'),
            'status'      => $request->input('status')
        ]));

        if($send) {
            return response()->json(['code'=>200, 'message'=>'Email sent successfully!']);
        }

        return response()->json(['code'=>400, 'message'=>'Email sent error!']);
    }
}
