<?php

namespace Modules\Auth\Entities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Auth\Entities\Models\UserRole
 *
 * @property string $user_id
 * @property string $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserRole whereUserId($value)
 */
class UserRole extends Model
{
    use Uuid;
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */

    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    protected $table   = 'dt_user_role';
}
