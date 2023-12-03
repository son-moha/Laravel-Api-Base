<?php

namespace Modules\Core\Constants;

class AppConst
{
    public const DATETIME_FORMAT = 'Y-m-d H:i:s';
    public const DATE_FORMAT = 'Y-m-d';
    public const TIME_FORMAT = 'H:i:s';

    public const COPY_RIGHT = 'Copyright © 2021';
    public const LIMIT_PER_PAGE = 10;
    public const PAGE_LIMIT_DEFAULT = 20;

    public const QUEUE_LEVEL_IMMEDIATE = 'immediate';
    public const QUEUE_LEVEL_HIGH = 'high';
    public const QUEUE_LEVEL_MEDIUM = 'medium';
    public const QUEUE_LEVEL_LOW = 'low';

    public const QUEUE_LEVEL_MAIL = 'mail';
    public const QUEUE_LEVEL_LOG = 'log';

    public const QUEUE_LEVEL_REMIND = 'remind';
    public const QUEUE_LEVEL_IMPORT = 'import';

    public const SUCCESS = 'success';
    public const FAILED = 'failed';
}
