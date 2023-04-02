<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SalaryUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $newSalary;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $newSalary)
    {
        $this->name = $name;
        $this->newSalary = $newSalary;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Salary Updated',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content('emails.newSalary',

        );
    }

    public function build()
    {
        return $this->view('emails.newSalary',  [
            'name'=>$this->name,
            'salary'=>$this->newSalary
        ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
