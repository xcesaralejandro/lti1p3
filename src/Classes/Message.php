<?php

namespace xcesaralejandro\lti1p3\Classes;
use Illuminate\Support\Facades\Log;
use xcesaralejandro\lti1p3\Classes\Content;
use xcesaralejandro\lti1p3\Facades\JWT;
use xcesaralejandro\lti1p3\Models\LtiNonce;
use App\Models\LtiPlatform;

class Message {

    private string $raw_jwt;
    private Content $content;
    private LtiPlatform $platform;
    const LTI_DEEP_LINKING_REQUEST = 'LtiDeepLinkingRequest';
    const LTI_RESOURCE_LINK_REQUEST = 'LtiResourceLinkRequest';

    function __construct(string $jwt, string $nonce) {
        $this->raw_jwt = $jwt;
        $nonce = LtiNonce::findOrFail($nonce);
        $this->platform = $nonce->platform()->firstOrFail();
        $this->content = $this->getContentFromToken();
        TokenValidator::validOrFail($this->content, $this->platform);
        $nonce->delete();
    }

    public function getPlatform() : LtiPlatform {
        return $this->platform;
    }

    public function getContent() : Content {
        return $this->content;
    }

    public function getType() : string {
        return $this->content->getMessageType();
    }

    public function isDeepLinking() : bool {
        return $this->getType() == static::LTI_DEEP_LINKING_REQUEST;
    }

    public function isResourceLink() : bool {
        return $this->getType() == static::LTI_RESOURCE_LINK_REQUEST;
    }

    public function getRawJwtContent() : string {
        return $this->raw_jwt;
    }

    private function getContentFromToken() : Content {
        $jwk = $this->platform->getPublicJwk();
        $raw_content = JWT::decode($this->raw_jwt, $jwk);
        $content = new Content($raw_content);
        return $content;
    }

    public static function decodeJWT(LtiPlatform $platform, string $initial_message) : Content {
        $jwk = $platform->getPublicJwk();
        $raw_content = JWT::decode($initial_message, $jwk);
        $content = new Content($raw_content);
        return $content;
    }

}
