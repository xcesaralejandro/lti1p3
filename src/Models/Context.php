<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\Deployment;
use App\Models\Platform;
use App\Models\ResourceLink;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Context extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['deployment_id','lti_id', 'label', 'title', 'type'];

    public function resourceLinks() : HasMany {
        return $this->hasMany(ResourceLink::class, 'context_id', 'id');
    }

    public function deployment() : BelongsTo {
        return $this->belongsTo(Deployment::class, 'deployment_id', 'id');
    }

    public function roles() : HasMany {
        return $this->hasMany(UserRole::class, 'lti_context_id', 'id');
    }
}
