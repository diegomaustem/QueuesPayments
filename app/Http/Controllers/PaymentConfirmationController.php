<?php

namespace App\Http\Controllers;

use App\Jobs\PaymentConfirmationJob;
use Illuminate\Http\Request;

class PaymentConfirmationController extends Controller
{
    public function paymentDetailsReceived(Request $request)
    {
        $paymentDetails = $request->all();

        PaymentConfirmationJob::dispatch($paymentDetails)->delay(now()->addSeconds(3))->onQueue('PaymentConfirmationJob');
    }
}
