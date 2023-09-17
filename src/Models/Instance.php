<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\Context;
use App\Models\Deployment;
use App\Models\Platform;
use App\Models\ResourceLink;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use xcesaralejandro\lti1p3\Classes\Message;

class Instance extends Authenticatable
{

    protected $table = 'lti1p3_instances';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['id', 'platform_id', 'deployment_id', 'context_id', 'resource_link_id', 'user_id', 'initial_message', 'created_at'];

    public function platform() : BelongsTo {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function context() : BelongsTo {
        return $this->belongsTo(Context::class, 'context_id');
    }

    public function deployment() : BelongsTo {
        return $this->belongsTo(Deployment::class, 'deployment_id');
    }

    public function resource_link() : BelongsTo {
        return $this->belongsTo(ResourceLink::class, 'resource_link_id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeRecoveryFromId(mixed $query, string $id) : mixed {
        return $query->where('id', $id)->with(['platform', 'context', 'resource_link', 'user'])->firstOrFail();
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
