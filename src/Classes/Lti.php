<?php

namespace xcesaralejandro\lti1p3\Classes;
use Illuminate\Support\Facades\Log;
use xcesaralejandro\lti1p3\Classes\Content;
use xcesaralejandro\lti1p3\Facades\JWT;
use xcesaralejandro\lti1p3\Models\Nonce;
use xcesaralejandro\lti1p3\Models\Platform;

class Lti {
    private string $raw_jwt;
    private Content $content;
    private Platform $platform;

    function xd(){
        echo 'xd';
    }
    
    function init(string $jwt, string $nonce) : void 
    {
        Log::debug('[Lti::class] [init] Starting Lti class validations');
        $this->raw_jwt = $jwt;
        $nonce = Nonce::where(['value' => $nonce])->firstOrFail();
        $this->platform = $nonce->platform()->firstOrFail();
        $this->content = $this->getContentFromToken();
        TokenValidator::validOrFail($this->content, $this->platform);
        $nonce->delete();
        Log::debug('[Lti::class] [init] Lti class was constructed correctly');
    }

    public function getPlatform() : Platform 
    {
        return $this->platform;
    }

    public function getContent() : Content 
    {
        return $this->content;
    }

    public function getRawJwtContent() : string 
    {
        return $this->raw_jwt;
    }

    private function getContentFromToken() : object 
    {
        $jwk = $this->platform->getPublicJwk();
        $signature_method = $this->platform->signature_method;
        $raw_content = JWT::decode($this->raw_jwt, $jwk, array($signature_method));
        $content = new Content($raw_content);
        Log::debug('[Lti::class] Jwt decoded successfully');
        return $content;
    }

}
