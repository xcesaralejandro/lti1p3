<?php
namespace xcesaralejandro\lti1p3\Classes;
use Carbon\Carbon;
use xcesaralejandro\lti1p3\DataStructure\Claims;

class Content {

    const LTI_STANDARD_CLAIM = 'https://purl.imsglobal.org/spec/lti/claim/';
    const LTI_DEEP_LINKING_SPEC_CLAIM = 'https://purl.imsglobal.org/spec/lti-dl/claim/';
    private object $raw_content;
    protected $leeway = 120;

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

    public function getUserRoles() : array {
        $property = $this->StandardClaimFor('roles');
        return $this->getJwtRProperty($property) ?? [];
    }

    public function getLis() : ?object {
        $property = $this->StandardClaimFor('lis');
        return $this->getJwtRProperty($property);
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
        $property = $this->StandardClaimFor('version');
        return $this->getJwtRProperty($property);
    }

    public function getDeploymentId() : string {
        $property = $this->StandardClaimFor('deployment_id');
        return $this->getJwtRProperty($property);
    }

    public function hasTargetLinkUriRedirection() : bool {
        return $this->getTargetLinkUri() != route('lti1p3.connect');
    }

    public function getTargetLinkUri(array $extra_params = []) : string {
        $property = $this->StandardClaimFor('target_link_uri');
        $url = $this->getJwtRProperty($property);
        return $this->addParamsToUrl($url, $extra_params);
    }

    private function addParamsToUrl(string $url, array $params) : string {
        if(!count($params) > 0){
            return $url;
        }
        foreach($params as $name => $value){
            $concat = str_contains($url, '?') ? '&' : '?';
            $url .= "{$concat}{$name}={$value}";
        }
        return $url;
    }

    public function getPlatform() : object {
        $property = $this->StandardClaimFor('tool_platform');
        return $this->getJwtRProperty($property);
    }

    public function getDeepLinkingSettings() : ?object {
        $key = static::LTI_DEEP_LINKING_SPEC_CLAIM."deep_linking_settings";
        return $this->raw_content->$key ?? null;
    }

    public function getMessageType() : string {
        $property = $this->StandardClaimFor('message_type');
        return $this->getJwtRProperty($property);
    }

    public function getContext() : ?object {
        $property = $this->StandardClaimFor('context');
        return $this->getJwtRProperty($property);
    }

    public function getResourceLink() : object {
        $property = $this->StandardClaimFor('resource_link');
        return $this->getJwtRProperty($property);
    }

    public function getAllCustomVars() : ?object {
        $property = $this->StandardClaimFor('custom');
        $vars = $this->getJwtRProperty($property) ?? null;
        return $vars;
    }

    public function getCustomVar(string $name) : mixed {
        $vars = $this->getAllCustomVars();
        return $vars->{$name} ?? null;
    }

    public function hasCustomVar(string $name) : bool {
        $vars = $this->getAllCustomVars();
        return isset($vars->{$name});
    }

    public function getCustomVarOrFail(string $name) : mixed {
        if($this->hasCustomVar($name)){
            return $this->getCustomVar($name);
        }else{
            $message = "Custom var {$name} is not passed from the LMS. Please review the tool settings within the LMS.";
            throw new \Exception($message);
        }
    }

    public function tokenIsExpired() : bool {
        $now = Carbon::now('UTC')->timestamp;
        $expiration = $this->raw_content->exp;
        $lifetime = ($expiration + $this->leeway) - $now;
        $isExpired = $lifetime < 0;
        return $isExpired;
    }

    private function StandardClaimFor(string $property_name) : string {
        return self::LTI_STANDARD_CLAIM . $property_name;
    }

    private function getJwtRProperty(string $property, bool $required = true) : mixed {
        if($required){
            $this->assertExist($property);
        }
        return $this->raw_content->$property ?? null;
    }

    private function assertExist(string $property){
        if(!isset($this->raw_content->$property)){
            $message = "[Content::class] Property {$property} not found inside Jwt";
            throw new \Exception($message);
        }
    }
}
