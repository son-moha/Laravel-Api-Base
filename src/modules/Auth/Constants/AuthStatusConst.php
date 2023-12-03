<?php

namespace Modules\Auth\Constants;

class AuthStatusConst
{
    public const USER_ENABLE = 1;
    public const USER_DISABLE = 0;

    public const USER_GENDER_MALE = 1;
    public const USER_GENDER_FEMALE = 2;

    public const STATUS_USER_ENABLE = 1;
    public const STATUS_USER_DISABLE = 0;

    public const USER_STATUSES = [
        'enable' => self::USER_ENABLE,
        'disable' => self::USER_DISABLE
    ];
}
