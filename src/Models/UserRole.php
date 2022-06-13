<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class UserRole extends Model
{
    use HasFactory, SoftDeletes;

    const LTI = 'LTI';
    const LOCAL = 'LOCAL';

    protected $table = 'user_roles';

    protected $fillable = ['lti_context_id', 'user_id','name', 'creation_context'];

    public function context() : BelongsTo {
        return $this->belongsTo(Context::class, 'lti_context_id');
    }

    public function user () : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
