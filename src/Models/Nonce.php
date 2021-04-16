<?php

namespace xcesaralejandro\lti1p3\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Platform;

class Nonce extends Model
{
    use HasFactory;

    protected $table = 'nonces';
    protected $fillable = ['value', 'platform_id'];

    public function platform() : BelongsTo {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function assertMatchWith(string $nonce) : Void {
        if($nonce != $this->value){
            $message = "The nonce does not match the nonce of the lti content";
            throw new \Exception($message);
        }
    }
}
