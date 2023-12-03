<?php

namespace Modules\Auth\Entities\Mail;

use Modules\Core\Entities\Mails\Mailable;
use Modules\Auth\Entities\Models\User;

class ResetPassword extends Mailable
{
    /**
     * @var User
     */
    protected $user;

    protected $token;

    /**
     * ResetPassword constructor.
     * @param  User  $user
     * @param $token
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        return $this
            ->to($this->user->email)
            ->text('auth::_email.text.reset-password')
            ->subject('Reset password')
            ->with([
                'url' => route('password.reset.form', ['token' => $this->token, 'email' => $this->user->email]),
                'email' => $this->user->email
            ]);
    }
}
