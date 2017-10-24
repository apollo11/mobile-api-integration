<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeRegistration extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to YY Part-time Jobs')
            ->view('emails.employee-registration')
            ->with([
                'email' => $this->data['email'],
                'password' => $this->data['password'],
                'name' => $this->data['name'],
                'nric_no' => $this->data['nric_no']
            ]);
    }
}
