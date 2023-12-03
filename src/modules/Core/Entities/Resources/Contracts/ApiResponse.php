<?php

namespace Modules\Core\Entities\Resources\Contracts;

use Illuminate\Contracts\Support\Responsable;

abstract class ApiResponse implements Responsable
{
    abstract public function toArray($request);

    abstract public function httpStatus();

    abstract public function header();

    public function toResponse($request)
    {
        return response()->json($this->toArray($request), $this->httpStatus(), $this->header());
    }
}
