<?php

namespace xcesaralejandro\lti1p3\Classes;

use \Firebase\JWT\JWT as firebaseJWT;

class JWT extends firebaseJWT {

    public static $life = 60;

    public static $leeway = 180;

    public static $allowJkuHeader = false;

    public function buildJWKS(string $private_key, string $signature_method, string $kid) : array {
        $keys['keys'] = array();
        $res = openssl_pkey_get_private($private_key);
        if ($res === false) {
            $res = openssl_pkey_get_public($private_key);
        }
        if ($res !== false) {
            $details = openssl_pkey_get_details($res);
            $key = [
                'kty' => 'RSA',
                'n' => static::urlsafeB64Encode($details['rsa']['n']),
                'e' => static::urlsafeB64Encode($details['rsa']['e']),
                'alg' => $signature_method,
                'use' => 'sig'
            ];
            if (!empty($kid)) {
                $key['kid'] = $kid;
            }
            $keys['keys'][] = $key;
        }
        return $keys;
    }
}