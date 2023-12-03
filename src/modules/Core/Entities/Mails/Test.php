<?php

namespace Modules\Core\Entities\Mails;

class Test extends Mailable
{
    protected $email;

    /**
     * Test constructor.
     *
     * @param $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this
            ->to($this->email)
            ->text('core::_email.text.test')
            ->subject('Test mail');
    }
}
