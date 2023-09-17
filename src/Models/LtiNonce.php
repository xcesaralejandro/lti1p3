<?php

namespace xcesaralejandro\lti1p3\Models;

use App\Models\LtiPlatform;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class LtiNonce extends Model
{
    use HasFactory;

    protected $table = 'lti1p3_nonces';
    protected $fillable = ['value', 'lti1p3_platform_id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($nonce){
            $nonce->value = Uuid::uuid4()->toString();
        });
    }

    public function platform() : BelongsTo {
        return $this->belongsTo(LtiPlatform::class, 'lti1p3_platform_id');
    }

    public function assertMatchWith(string $nonce) : Void {
        if($nonce != $this->value){
            $message = "The nonce does not match the nonce of the lti content";
            throw new \Exception($message);
        }
    }
}
