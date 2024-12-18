<?php

namespace App\Jobs;

use App\Mail\PaymentConfirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaymentConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private $paymentDetails = [];

    public function __construct($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $senderName  = $this->paymentDetails['name'];
        $senderEmail = $this->paymentDetails['email'];

        $emailSend = Mail::to($senderEmail, $senderName)->send(new PaymentConfirmation([
            'name'        => $this->paymentDetails['name'],
            'subject'     => $this->paymentDetails['subject'],
            'email'       => $this->paymentDetails['email'],
            'transaction' => $this->paymentDetails['transaction'],
            'value'       => $this->paymentDetails['value'],
            'description' => $this->paymentDetails['description'],
            'status'      => $this->paymentDetails['status']
        ]));
    }
}
