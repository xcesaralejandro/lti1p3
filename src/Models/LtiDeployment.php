<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiContext;
use App\Models\LtiPlatform;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LtiDeployment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lti1p3_deployments';
    protected $fillable = ['lti1p3_platform_id', 'lti_id', 'creation_method'];

    public function platform() : BelongsTo {
        return $this->belongsTo(LtiPlatform::class, 'lti1p3_platform_id');
    }

    public function contexts() : HasMany {
        return $this->hasMany(LtiContext::class, 'id');
    }
}
