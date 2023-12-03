<?php

namespace Modules\Core\Entities\Resources\Errors\Http;

use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Errors\ApiErrorResponse;

class ServerErrorResponse extends ApiErrorResponse
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function httpStatus()
    {
        return 500;
    }

    public function getErrorCode(): string
    {
        return HttpStatus::STATUS_500;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
