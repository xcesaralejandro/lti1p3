<?php

namespace xcesaralejandro\lti1p3\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Context extends Model
{
    use HasFactory;

    protected $fillable = ['platform_id','lti_id', 'label', 'title', 'type'];

    public function resourceLinks() : HasMany {
        return $this->hasMany(ResourceLink::class, 'context_id', 'id');
    }

    public function platform() : BelongsTo {
        return $this->belongsTo(Platform::class, 'platform_id', 'id');
    }
}
