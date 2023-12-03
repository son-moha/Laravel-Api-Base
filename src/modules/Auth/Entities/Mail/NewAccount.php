<?php

namespace Modules\Auth\Entities\Mail;

use Modules\Core\Entities\Mails\Mailable;

class NewAccount extends Mailable
{
    protected $email;

    protected $password;

    /**
     * NewAccount constructor.
     *
     * @param $email
     * @param $password
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function build()
    {
        return $this
            ->to($this->email)
            ->text('auth::_email.text.new-account')
            ->subject('New Account')
            ->with([
                'email' => $this->email,
                'password' => $this->password
            ]);
    }
}
