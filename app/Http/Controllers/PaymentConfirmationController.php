<?php

namespace App\Http\Controllers;

use App\Jobs\PaymentConfirmationJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentConfirmationController extends Controller
{
    public function paymentDetailsReceived(Request $request)
    {
        $paymentDetails = $request->all();

        try {
            PaymentConfirmationJob::dispatch($paymentDetails)->delay(now()->addSeconds(3))->onQueue('PaymentConfirmationJob');

            return response()->json(['message' => 'Payment successfully!'], 200);
        } catch(\Exception $e) {
            // Caso exista algum error, armazenaremos em log ::: 
            Log::error('An error occurred: ' . $e->getMessage());
            
            return response()->json(['error' => 'Payment error!'], 500);
        }
    }
}
