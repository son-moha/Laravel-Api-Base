<?php

namespace Modules\Core\Entities\Mails;

class ErrorReport extends Mailable
{
    protected $email;
    protected $message;

    /**
     * ErrorReport constructor.
     *
     * @param $email
     * @param $message
     */
    public function __construct($email, $message)
    {
        $this->email = $email;
        $this->message = $message;
    }

    public function build()
    {
        return $this
            ->to($this->email)
            ->markdown('core::_email.html.error_report')
            ->subject('Error Report')
            ->with(['message' => $this->message]);
    }
}
