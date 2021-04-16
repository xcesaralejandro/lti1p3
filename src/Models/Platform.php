<?php

namespace xcesaralejandro\lti1p3\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use App\Models\Nonce;
use GuzzleHttp\Client;
use \Firebase\JWT\JWK;
use Illuminate\Support\Facades\Log;

class Platform extends Model
{
    use HasFactory;

    protected $table = 'platforms';
    protected $fillable = ['issuer_id', 'client_id', 'deployment_id', 'target_link_uri',
    'authorization_url', 'authentication_url', 'json_webkey_url','signature_method',
    'name', 'version', 'product_family_code', 'validation_context', 'guid'];

    public function users() : HasMany {
        return $this->hasMany(User::class, 'platform_id', 'id');
    }

    public function contexts() : HasMany {
        return $this->hasMany(Context::class, 'platform_id', 'id');
    }

    public function nonces() : HasMany{
        return $this->hasMany(Nonce::class, 'platform_id', 'id');
    }

    public function getPublicJwk() : array {
        $client = new Client();
        $response = $client->get($this->json_webkey_url);
        $public_jwks = json_decode($response->getBody()->getContents(), true);
        $keys = JWK::parseKeySet($public_jwks);
        Log::debug('[Platform::class] Getting the public Jwk of the platform',
        ['url' => $this->json_webkey_url]);
        return $keys;
    }

}
