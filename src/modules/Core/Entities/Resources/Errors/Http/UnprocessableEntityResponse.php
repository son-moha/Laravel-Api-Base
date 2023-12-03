<?php

namespace Modules\Core\Entities\Resources\Errors\Http;

use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Errors\ApiErrorResponse;

class UnprocessableEntityResponse extends ApiErrorResponse
{
    public function httpStatus()
    {
        return 422;
    }

    public function getErrorCode(): string
    {
        return HttpStatus::STATUS_422;
    }

    public function getMessage(): string
    {
        return trans('core::error.The given data was invalid');
    }
}
