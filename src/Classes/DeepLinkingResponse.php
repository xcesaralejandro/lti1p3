<?php
namespace xcesaralejandro\lti1p3\Classes;

use App\Models\Instance;
use Carbon\Carbon;
use xcesaralejandro\lti1p3\Models\Nonce;

class DeepLinkingResponse {

    private array $payload;

    const MESSAGE_TYPE = 'LtiDeepLinkingResponse';
    const LTI_VERSION = '1.3.0';
    const DEPLOYMENT_CLAIM = 'https://purl.imsglobal.org/spec/lti/claim/deployment_id';
    const MESSAGE_TYPE_CLAIM = 'https://purl.imsglobal.org/spec/lti/claim/message_type';
    const LTI_VERSION_CLAIM = 'https://purl.imsglobal.org/spec/lti/claim/version';
    const CONTENT_ITEMS_CLAIM = 'https://purl.imsglobal.org/spec/lti-dl/claim/content_items';
    const DATA_CLAIM = 'https://purl.imsglobal.org/spec/lti-dl/claim/data';

    function __construct(Instance $instance){
        $this->instance = $instance;
        $this->initPayload();
    }

    public function addContentItem(array $content_item) : array {
        array_push($this->payload[static::CONTENT_ITEMS_CLAIM], $content_item);
        return $this->getAllContentItem();
    }

    public function removeContentItem(int|string $index) : array {
        if(isset($this->payload[static::CONTENT_ITEMS_CLAIM][$index])){
            unset($this->payload[static::CONTENT_ITEMS_CLAIM][$index]);
        }
        return $this->getAllContentItem();
    }

    public function getAllContentItem() : array {
        return $this->payload[static::CONTENT_ITEMS_CLAIM];
    }

    public function get(){
        $jwt = $this->buildJWT();
        $url = $this->getFormUrl();
        return ['url' => $url, 'params' => ['JWT' => $jwt]];
    }

    private function initPayload() : void {
        $this->payload = [
            "iss" => $this->instance->platform->client_id,
            "aud" => $this->instance->platform->issuer_id,
            "exp" => Carbon::now()->addSeconds(3600)->timestamp,
            "iat" => Carbon::now()->subSeconds(120)->timestamp,
            "nonce" => $this->getNonce(),
            static::DEPLOYMENT_CLAIM => $this->getDeploymentId(),
            static::MESSAGE_TYPE_CLAIM => static::MESSAGE_TYPE,
            static::LTI_VERSION_CLAIM => static::LTI_VERSION,
            static::CONTENT_ITEMS_CLAIM => [],
            static::DATA_CLAIM => $this->getDeepLinkingSettings(),
        ];
    }

    private function getNonce() : string {
        $nonce = Nonce::create(['platform_id' => $this->instance->platform->id]);
        return $nonce->value;
    }

    private function getDeploymentId() : string {
        return $this->instance->deployment->lti_id;
    }

    private function getDeepLinkingSettings() : ?object {
        $content = Message::decodeJWT($this->instance->platform, $this->instance->initial_message);
        return $content->getDeepLinkingSettings();
    }

    private function getFormUrl() : string {
        $deep_linking_settings = $this->getDeepLinkingSettings();
        if(empty($deep_linking_settings)){
            $message = "The required parameter deep_linking_settings is null. Make sure the LMS is delivering this value.";
            throw new \Exception($message);
        }
        return $deep_linking_settings->deep_link_return_url;
    }

    private function buildJWT () : string {
        $private_key = config('lti1p3.PRIVATE_KEY');
        $signature_method = config('lti1p3.SIGNATURE_METHOD');
        $kid = config('lti1p3.KID');
        $jwt = JWT::encode($this->payload, $private_key, $signature_method, $kid);
        return $jwt;
    }

    //     return View('lti1p3::helpers.autoSubmitForm', ['url' => $url, 'params' => $params]); 
}
