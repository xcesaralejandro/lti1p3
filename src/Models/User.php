<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\Platform;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use xcesaralejandro\lti1p3\Traits\LtiRolesManager;

class User extends Authenticatable
{
    use LtiRolesManager, SoftDeletes;

    protected $table = 'users';

    protected $fillable = ['platform_id','lti_id', 'password', 'name', 'given_name', 'family_name',
    'email', 'picture', 'person_sourceid', 'creation_method'];
    protected $hidden = ['password', 'remember_token'];

    public function platform() : BelongsTo {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function roles() : HasMany {
        return $this->hasMany(Role::class, 'role_id', 'id');
    }

    public function isToolAdmin() : bool {
        return $this->hasRole('administrator', UserRole::LOCAL);
    }

    public function hasRole(string $role_name, string $creation_context) : bool {
        $finded_roles_count = UserRole::where([['creation_context', '=', $creation_context], ['name', '=',$role_name], ['user_id', '=', $this->id]])->count(); 
        return $finded_roles_count > 0;
    }

    private function has(string $column) : bool {
        return !empty($column);
    }
}
