<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiPlatform;
use App\Models\LtiUserRole;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use xcesaralejandro\lti1p3\Traits\LtiRolesManager;

class LtiUser extends Authenticatable
{
    use LtiRolesManager, SoftDeletes;

    protected $table = 'lti1p3_users';
    protected $fillable = ['lti1p3_platform_id','lti_id', 'name', 'given_name', 'family_name',
    'email', 'picture', 'person_sourceid', 'creation_method'];

    public function platform() : BelongsTo {
        return $this->belongsTo(LtiPlatform::class, 'lti1p3_platform_id');
    }

    public function roles() : HasMany {
        return $this->hasMany(LtiUserRole::class, 'lti1p3_user_id', 'id');
    }

}
