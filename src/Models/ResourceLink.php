<?php

namespace xcesaralejandro\lti1p3\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Context;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ResourceLink extends Model
{
    use HasFactory;

    protected $fillable = ['context_id', 'lti_id', 'description', 'title', 'validation_context'];

    public function context() : BelongsTo {
        return $this->belongsTo(Context::class, 'context_id');
    }

    public function certConfig() : HasOne {
        return $this->hasOne(CertConfig::class, 'resource_link_id', 'id');
    }
}