<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiDeployment;
use App\Models\LtiPlatform;
use App\Models\LtiResourceLink;
use App\Models\LtiUserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LtiContext extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lti1p3_contexts';
    protected $fillable = ['lti1p3_deployment_id','lti_id', 'label', 'title', 'type'];

    public function resourceLinks() : HasMany {
        return $this->hasMany(LtiResourceLink::class, 'lti1p3_context_id', 'id');
    }

    public function deployment() : BelongsTo {
        return $this->belongsTo(LtiDeployment::class, 'lti1p3_deployment_id', 'id');
    }

    public function roles() : HasMany {
        return $this->hasMany(LtiUserRole::class, 'lti1p3_context_id', 'id');
    }
}
