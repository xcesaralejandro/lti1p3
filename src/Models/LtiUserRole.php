<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\Context;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LtiUserRole extends Model
{
    use HasFactory, SoftDeletes;

    const LTI = 'LTI';
    const LOCAL = 'LOCAL';

    protected $table = 'lti1p3_user_roles';

    protected $fillable = ['lti1p3_context_id', 'lti1p3_user_id','name', 'creation_context'];

    public function context() : BelongsTo {
        return $this->belongsTo(LtiContext::class, 'lti1p3_context_id');
    }

    public function user () : BelongsTo {
        return $this->belongsTo(LtiUser::class, 'lti1p3_user_id');
    }
}
