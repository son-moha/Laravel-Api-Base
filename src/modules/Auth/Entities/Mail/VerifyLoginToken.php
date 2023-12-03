<?php

namespace Package\Modules\Auth\Entities\Mail;

use Modules\Core\Entities\Mails\Mailable;

class VerifyLoginToken extends Mailable
{
    protected $user;
    protected $token;

    public function __construct($user, $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this
            ->to($this->user->email)
            ->text('auth::_email.text.token_verify')
            ->subject('Verify Login')
            ->with([
                'user'  => $this->user,
                'token' => $this->token
            ]);
    }
}
