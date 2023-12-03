<?php

namespace Modules\Core\Entities\Resources\Errors\Http;

use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Errors\ApiErrorResponse;

class ForbiddenResponse extends ApiErrorResponse
{
    public function httpStatus()
    {
        return 403;
    }

    public function getErrorCode(): string
    {
        return HttpStatus::STATUS_403;
    }

    public function getMessage(): string
    {
        return trans('core::error.Forbidden');
    }
}
