<?php

namespace Modules\Auth\Services;

use Modules\Core\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Auth\Entities\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResetPasswordService extends BaseService
{
    public function resetPassword(User $user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        return $user;
    }

    public function checkExpire($email)
    {
        return DB::table('ms_password_resets')
            ->where('email', '=', $email)
            ->where('created_at', '>', Carbon::now()
                ->subHour())
            ->first();
    }
}
