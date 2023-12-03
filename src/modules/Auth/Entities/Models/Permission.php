<?php

namespace Modules\Auth\Entities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Auth\Database\Factories\PermissionFactory;
use Modules\Core\Entities\Models\Uuid;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Auth\Entities\Models\Permission
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Auth\Entities\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Modules\Auth\Database\Factories\PermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
class Permission extends Model
{
    use Uuid;
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PermissionFactory::new();
    }

    protected $guarded = [];

    protected $table = 'ms_permissions';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'dt_permission_role')->withTimestamps();
    }
}
