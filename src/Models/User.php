<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\Platform;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use xcesaralejandro\lti1p3\Traits\LtiRolesManager;

class User extends Authenticatable
{
    use LtiRolesManager;

    protected $table = 'users';

    protected $fillable = ['platform_id','lti_id', 'password', 'name', 'given_name', 'family_name',
    'email', 'picture', 'roles', 'person_sourceid', 'creation_method', 'app_role'];
    protected $hidden = ['password', 'remember_token'];

    public function platform() : BelongsTo {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function isToolAdmin() : bool {
        return $this->app_role == 'ADMIN' && $this->has('email') && $this->has('password');
    }

    private function has(string $column) : bool {
        return !empty($column);
    }
}
