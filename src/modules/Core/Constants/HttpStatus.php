<?php

namespace Modules\Core\Constants;

class HttpStatus
{
    public const STATUS_200 = 'client/success';
    public const STATUS_400 = 'client/bad_request';
    public const STATUS_401 = 'client/unauthorized';
    public const STATUS_403 = 'client/forbidden';
    public const STATUS_404 = 'client/not_found';
    public const STATUS_405 = 'client/method_not_allowed';
    public const STATUS_422 = 'client/unprocessable_entity';
    public const STATUS_429 = 'client/too_many_request';
    public const STATUS_500 = 'client/internal_server_error';
}
