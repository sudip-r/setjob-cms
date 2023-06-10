<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\AlterBase\Repositories\User\UserRepository;

class EmployeeWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var $user
     */
    private $user;
    /**
     * Create a new message instance.
     *
     * @param $id
     * @return void
     */
    public function __construct($id)
    {
        $user = new UserRepository(app());
        $this->user = $user->find($id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trim($this->subject, 'Welcome to Set Jobs'))->markdown('email.welcome_employee')->with('user', $this->user);
    }
}
