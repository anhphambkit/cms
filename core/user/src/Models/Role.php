<?php 
namespace Core\User\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Core\User\Traits\PermissionTrait;
class Role extends Model
{
    use SoftDeletes,
        PermissionTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_staff',
        'is_default',
        'created_by',
        'updated_by',
    ];

    /**
     * Returns the list of flags that belong to this role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @author TrinhLe
     */
    public function flags()
    {
        return $this->belongsToMany(PermissionFlag::class, 'role_flags', 'role_id', 'flag_id');
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id', 'user_id');
    }
}
