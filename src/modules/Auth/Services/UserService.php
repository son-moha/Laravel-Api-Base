<?php

namespace Modules\Auth\Services;

use Carbon\Carbon;
use Modules\Auth\Constants\AuthStatusConst;
use Modules\Core\Services\BaseService;
use Illuminate\Support\Str;
use Modules\Auth\Constants\AuthConst;
use Modules\Auth\Repositories\RoleRepository;
use Modules\Auth\Repositories\UserRepository;

class UserService extends BaseService
{
    protected $roleRepository;

    public function __construct(
        UserRepository $repository,
        RoleRepository $roleRepository
    ) {
        $this->mainRepository = $repository;
        $this->roleRepository = $roleRepository;
    }

    public function makePassword()
    {
        return Str::random(8);
    }

    public function addLastLogin($id)
    {
        $attribute = [
            "last_login" => Carbon::now()->toDateTimeString(),
        ];

        return $this->mainRepository->update($id, $attribute);
    }

    public function getRoles()
    {
        return $this->roleRepository->all();
    }

    public function ajaxSearch($options, $limit)
    {
        $options['limit'] = $limit;
        $fillable         = $this->mainRepository->getFillable();
        $all_request      = $this->filterRequest(app('request'));
        $filter           = collect($all_request['filter']);
        $this->makeBuilder($options);

        if (isset($filter['status'])) {
            $filter['status'] = AuthStatusConst::USER_STATUSES[$filter['status']];
        }

        if (isset($filter['role'])) {
            $filter['role_name'] = AuthConst::USER_ROLES[$filter['role']];
        }

        foreach ($filter as $k => $v) {
            if (in_array($k, $fillable)) {
                $this->builder->where($k, 'LIKE', "%" . $v . "%");
                $this->cleanFilterBuilder([$k]);

                continue;
            }

            if ($k == 'role_name') {
                $this->builder->whereRelation('roles', 'name', $filter[$k]);
                $this->cleanFilterBuilder([$k]);
            }
        }

        return $this->endFilter();
    }
}
