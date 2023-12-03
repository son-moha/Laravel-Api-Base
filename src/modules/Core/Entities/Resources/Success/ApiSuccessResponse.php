<?php

namespace Modules\Core\Entities\Resources\Success;

use Illuminate\Contracts\Support\Responsable;
use Modules\Core\Constants\AppConst;
use Modules\Core\Constants\HttpStatus;
use Modules\Core\Entities\Resources\Contracts\ApiResponse;

class ApiSuccessResponse extends ApiResponse implements Responsable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function toArray($request)
    {
        return [
            'status' => AppConst::SUCCESS,
            'data'   => $this->data
        ];
    }

    public function httpStatus()
    {
        return 200;
    }

    public function header()
    {
        return [];
    }
}
