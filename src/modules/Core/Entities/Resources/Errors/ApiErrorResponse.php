<?php

namespace Modules\Core\Entities\Resources\Errors;

use Illuminate\Contracts\Support\Responsable;
use Modules\Core\Constants\AppConst;
use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Contracts\ApiResponse;

abstract class ApiErrorResponse extends ApiResponse implements Responsable
{
    public function toArray($request)
    {
        return [
            'status' => AppConst::FAILED,
            'error'  => [
                'code'    => $this->getErrorCode(),
                'message' => $this->getMessage(),
            ]
        ];
    }

    public function httpStatus()
    {
        return HttpStatus::STATUS_400;
    }

    public function header()
    {
        return [];
    }

    public function toResponse($request)
    {
        return response()->json($this->toArray($request), $this->httpStatus());
    }

    abstract public function getMessage(): string;

    abstract public function getErrorCode(): string;
}
