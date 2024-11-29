<?php

namespace xcesaralejandro\lti1p3\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\LtiContext;
use Illuminate\Database\Eloquent\SoftDeletes;

class LtiResourceLink extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lti1p3_resource_links';
    
    protected $fillable = ['lti1p3_context_id', 'lti_id', 'description', 'title'];

    public function context() : BelongsTo {
        return $this->belongsTo(LtiContext::class, 'lti1p3_context_id');
    }

}
