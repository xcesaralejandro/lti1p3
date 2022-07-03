<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\Context;
use App\Models\Deployment;
use App\Models\Platform;
use App\Models\ResourceLink;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use xcesaralejandro\lti1p3\Classes\Message;

class Instance extends Authenticatable
{
    
    protected $table = 'instances';

    protected $keyType = 'string';

    public $incrementing = false;

    const UPDATED_AT = null;
    
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
}
