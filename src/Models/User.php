<?php

namespace xcesaralejandro\lti1p3\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LtiRolesManager;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // use HasFactory, Notifiable, LtiRolesManager;

    protected $table = 'users';

    protected $fillable = ['platform_id','lti_id', 'password', 'name', 'given_name', 'family_name',
    'email', 'picture', 'roles', 'person_sourceid', 'creation_method', 'app_role'];
    protected $hidden = ['password', 'remember_token'];

    public function platform() : BelongsTo {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function isAdmin() : bool {
        return $this->app_role == 'ADMIN' && $this->has('email') && $this->has('password');
    }

    private function has(string $column){
        return !empty($column);
    }
}
