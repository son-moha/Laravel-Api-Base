<?php

namespace Modules\Core\Entities\Resources\Errors\Http;

use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Errors\ApiErrorResponse;

class MethodNotAllowedResponse extends ApiErrorResponse
{
    public function httpStatus()
    {
        return 405;
    }

    public function getErrorCode(): string
    {
        return HttpStatus::STATUS_405;
    }

    public function getMessage(): string
    {
        return trans('core::error.Method Not Allowed');
    }
}
