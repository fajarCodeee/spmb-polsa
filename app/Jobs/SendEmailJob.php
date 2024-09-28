<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\SendNotificationsEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $email;
    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        // $this->email = $email;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new SendNotificationsEmail($this->data);
        Mail::to($this->data['email'])->send($email);
    }
}
