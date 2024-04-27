<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiContext;
use App\Models\LtiUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LtiUserRole extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lti1p3_user_roles';

    protected $fillable = ['lti1p3_context_id', 'lti1p3_user_id','name'];

    public function context() : BelongsTo {
        return $this->belongsTo(LtiContext::class, 'lti1p3_context_id');
    }

    public function user () : BelongsTo {
        return $this->belongsTo(LtiUser::class, 'lti1p3_user_id');
    }
}
