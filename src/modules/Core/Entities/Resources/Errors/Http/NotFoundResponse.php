<?php

namespace Modules\Core\Entities\Resources\Errors\Http;

use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Errors\ApiErrorResponse;

class NotFoundResponse extends ApiErrorResponse
{
    public function httpStatus()
    {
        return 404;
    }

    public function getErrorCode(): string
    {
        return HttpStatus::STATUS_404;
    }

    public function getMessage(): string
    {
        return trans('core::error.Not Found');
    }
}
