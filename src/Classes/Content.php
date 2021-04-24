<?php
namespace xcesaralejandro\lti1p3\Classes;
use Carbon\Carbon;
use xcesaralejandro\lti1p3\DataStructure\Claims;

class Content {

    const LTI_SPEC_CLAIM = 'https://purl.imsglobal.org/spec/lti/claim/';
    private object $raw_content;

    function __construct(object $raw_content)
    {
        $this->raw_content = $raw_content;
    }

    public function getUserId() : string 
    {
        return $this->getJwtProperty('sub');
    }

    public function getUserName() : string 
    {
        return $this->getJwtProperty('name');
    }

    public function getUserGivenName() : string 
    {
        return $this->getJwtProperty('given_name');
    }

    public function getUserFamilyName() : string 
    {
        return $this->getJwtProperty('family_name');
    }

    public function getUserEmail() : ?string 
    {
        $email = null;
        if(isset($this->raw_content->email)){
            $email = $this->raw_content->email;
        }
        return $email;
    }

    public function getUserPicture() : string 
    {
        return $this->getJwtProperty('picture');
    }

    public function getRawJwt() : object 
    {
        return $this->raw_content;
    }

    public function getIss() : string 
    {
        return $this->getJwtProperty('iss');
    }

    public function getAud() : string 
    {
        return $this->getJwtProperty('aud');
    }

    public function getLtiVersion() : string 
    {
        return $this->getClaims()->version;
    }

    public function getDeploymentId() : string 
    {
        return $this->getClaims()->deployment_id;
    }

    public function tokenIsExpired() : bool 
    {
        $now = Carbon::now('UTC')->timestamp;
        $tokenLifetime = $this->raw_content->exp;
        $lifetime = $tokenLifetime - $now;
        $isExpired = $lifetime < 0;
        return $isExpired;
    }

    public function getClaims() : Claims 
    {
        $claims = new Claims();
        foreach ($this->raw_content as $key => $content){
            if($this->isClaim($key)){
                $name = $this->getFriendlyClaimName($key);
                $claims->$name = $content;
            }
        }
        return $claims;
    }

    private function isClaim(string $key) : bool 
    {
        $isClaim = (strpos($key, self::LTI_SPEC_CLAIM) !== false);
        return $isClaim;
    }

    private function getFriendlyClaimName(string $key) : string 
    {
        $start = strlen(self::LTI_SPEC_CLAIM);
        $end = strlen($key);
        $name = substr($key, $start, $end);
        return $name;
    }

    private function getJwtProperty(string $property) : string 
    {
        $this->assertExist($property);
        return $this->raw_content->$property;
    }

    private function assertExist(string $property)
    {
        if(!isset($this->raw_content->$property)){
            $message = "[Content::class] Property {$property} not found inside Jwt";
            throw new \Exception($message);
        }
    }
}
