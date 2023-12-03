<?php

namespace Modules\Auth\Policies;

use Modules\Auth\Constants\PermissionConst;
use Modules\Auth\Entities\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function read(User $user)
    {
        //Return true if a user has permission to create-user
        return $user->permissions()->contains('user' . PermissionConst::PERMISSION_READ);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //Return true if a user has permission to create-user
        return $user->permissions()->contains('user' . PermissionConst::PERMISSION_CREATE);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $authenticatedUser
     * @param User $user
     * @return mixed
     */
    public function update(User $user)
    {
        //Return true if the authenticated user has the same id with specified model/user id
        //or has permission to update-user
        return $user->permissions()->contains('user' . PermissionConst::PERMISSION_UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function delete(User $user)
    {
        //Return true if an authenticated user has permission to delete-user
        return $user->permissions()->contains('user' . PermissionConst::PERMISSION_DELETE);
    }
}
