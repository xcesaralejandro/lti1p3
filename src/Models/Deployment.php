<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\Context;
use App\Models\Platform;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deployment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'deployments';

    protected $fillable = ['platform_id', 'lti_id', 'creation_method'];

    public function platform() : BelongsTo {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function contexts() : HasMany {
        return $this->hasMany(Context::class, 'id');
    }
}
