<?php

namespace Modules\Core\Entities\Resources\Errors\Http;

use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Errors\ApiErrorResponse;

class UnauthorizedResponse extends ApiErrorResponse
{
    public function httpStatus()
    {
        return 401;
    }

    public function getErrorCode(): string
    {
        return HttpStatus::STATUS_401;
    }

    public function getMessage(): string
    {
        return trans('core::error.Unauthorized');
    }
}
