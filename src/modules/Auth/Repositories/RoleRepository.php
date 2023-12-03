<?php

namespace Modules\Auth\Repositories;

use Modules\Core\Repositories\BaseRepository;
use Modules\Auth\Entities\Models\Role;

class RoleRepository extends BaseRepository
{
    public function model()
    {
        return Role::class;
    }
}
