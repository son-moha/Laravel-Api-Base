<?php

namespace Modules\Core\Entities\Resources\Errors\Http;

use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Errors\ApiErrorResponse;

class TooManyRequestResponse extends ApiErrorResponse
{
    public function httpStatus()
    {
        return 429;
    }

    public function getErrorCode(): string
    {
        return HttpStatus::STATUS_429;
    }

    public function getMessage(): string
    {
        return trans('core::error.Too Many Request');
    }
}
