<?php
namespace xcesaralejandro\lti1p3\Classes;
use Carbon\Carbon;
use xcesaralejandro\lti1p3\DataStructure\Claims;

class Content {

    const LTI_SPEC_CLAIM = 'https://purl.imsglobal.org/spec/lti/claim/';
    private object $raw_content;

    function __construct(object $raw_content){
        $this->raw_content = $raw_content;
    }

    public function getUserId() : string {
        return $this->getJwtRProperty('sub');
    }

    public function getUserName() : string {
        return $this->getJwtRProperty('name');
    }

    public function getUserGivenName() : string {
        return $this->getJwtRProperty('given_name');
    }

    public function getUserFamilyName() : string {
        return $this->getJwtRProperty('family_name');
    }

    public function getUserEmail() : ?string {
        return $this->getJwtRProperty('email', $required = false);
    }

    public function getUserPicture() : ?string {
        return $this->getJwtRProperty('picture', $required = false);
    }

    public function getRawJwt() : object {
        return $this->raw_content;
    }

    public function getIss() : string {
        return $this->getJwtRProperty('iss');
    }

    public function getAud() : string {
        return $this->getJwtRProperty('aud');
    }

    public function getLtiVersion() : string {
        return $this->getClaims()?->version;
    }

    public function getDeploymentId() : string {
        return $this->getClaims()?->deployment_id;
    }

    public function getPlatform() : object {
        return $this->getClaims()?->tool_platform;
    }

    public function optionalPlatformAttribute(string $attribute) {
        return $this->safe($this->getPlatform(), $attribute);
    }

    private function safe(?object $item, string $column) : mixed {
        return isset($item?->$column) ? $item->$column : null;
    }

    public function getContext() : object {
        return $this->getClaims()?->context;
    }

    public function getResourceLink() : object {
        return $this->getClaims()?->resource_link;
    }

    public function optionalResourceLinkAttribute(string $attribute) : mixed {
        return $this->safe($this->getResourceLink(), $attribute);
    }

    public function tokenIsExpired() : bool {
        $now = Carbon::now('UTC')->timestamp;
        $tokenLifetime = $this->raw_content->exp;
        $lifetime = $tokenLifetime - $now;
        $isExpired = $lifetime < 0;
        return $isExpired;
    }

    public function getClaims() : Claims {
        $claims = new Claims();
        foreach ($this->raw_content as $key => $content){
            if($this->isClaim($key)){
                $name = $this->getFriendlyClaimName($key);
                $claims->$name = $content;
            }
        }
        return $claims;
    }

    private function isClaim(string $key) : bool {
        $isClaim = (strpos($key, self::LTI_SPEC_CLAIM) !== false);
        return $isClaim;
    }

    private function getFriendlyClaimName(string $key) : string {
        $start = strlen(self::LTI_SPEC_CLAIM);
        $end = strlen($key);
        $name = substr($key, $start, $end);
        return $name;
    }

    private function getJwtRProperty(string $property, bool $required = true) : mixed {
        $value = null;
        if($required){
            $this->assertExist($property);
        }
        if(isset($this->raw_content?->$property)){
            $value = $this->raw_content->$property;
        }
        return $value;
    }

    private function assertExist(string $property){
        if(!isset($this->raw_content->$property)){
            $message = "[Content::class] Property {$property} not found inside Jwt";
            throw new \Exception($message);
        }
    }
}