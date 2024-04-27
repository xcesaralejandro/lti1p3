<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiContext;
use App\Models\LtiDeployment;
use App\Models\LtiPlatform;
use App\Models\LtiResourceLink;
use App\Models\LtiUser;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LtiInstance extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'lti1p3_instances';
    protected $keyType = 'string';
    public $incrementing = false;
    const UPDATED_AT = null;
    protected $with = ['platform', 'context', 'resource_link', 'user'];

    protected $fillable = ['id', 'lti1p3_platform_id', 'lti1p3_deployment_id', 'lti1p3_context_id',
    'lti1p3_resource_link_id', 'lti1p3_user_id', 'initial_message', 'created_at'];

    public function platform() : BelongsTo {
        return $this->belongsTo(LtiPlatform::class, 'lti1p3_platform_id');
    }

    public function context() : BelongsTo {
        return $this->belongsTo(LtiContext::class, 'lti1p3_context_id');
    }

    public function deployment() : BelongsTo {
        return $this->belongsTo(LtiDeployment::class, 'lti1p3_deployment_id');
    }

    public function resource_link() : BelongsTo {
        return $this->belongsTo(LtiResourceLink::class, 'lti1p3_resource_link_id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(LtiUser::class, 'lti1p3_user_id');
    }

    public function isExpired() : bool {
        $life_time = config('lti1p3.INSTANCE_LIFE_TIME');
        $timezone = config('app.timezone');
        if($life_time == null){
            return false;
        }
        if(!is_numeric($life_time)){
            $message = "INSTANCE_LIFE_TIME only support null for unlimited time or seconds in numbers.";
            throw new \Exception($message);
        }
        $now = Carbon::now($timezone);
        $dead_time = $this->created_at->timestamp + $life_time;
        return  $now->timestamp > $dead_time;
    }
}
