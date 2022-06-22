<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use xcesaralejandro\lti1p3\DataStructure\Instance;
use xcesaralejandro\lti1p3\Facades\JWT;
use xcesaralejandro\lti1p3\Facades\Launch;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;
use xcesaralejandro\lti1p3\Models\Nonce;
use xcesaralejandro\lti1p3\Models\User;
use GuzzleHttp\Psr7\Request;
use xcesaralejandro\lti1p3\Classes\Message;
use xcesaralejandro\lti1p3\DataStructure\DeepLinkingInstance;
use xcesaralejandro\lti1p3\DataStructure\ResourceLinkInstance;

class Lti1p3Controller {
    public function onResourceLinkRequest(ResourceLinkInstance $instance) : mixed {
        return View('lti1p3::welcome')->with(['instance' => $instance]);
    }

    public function onDeepLinkingRequest(DeepLinkingInstance $instance) : mixed {
        $this->deepLinkingForCreateResource($instance);
        return View('lti1p3::welcome')->with(['instance' => $instance]);
    }

    public function onError(mixed $exception = null) : mixed {
        return throw new \Exception($exception);
    }

    public function deepLinkingForCreateResource(DeepLinkingInstance $instance): mixed {
        $deeplinking_settings = $instance->message->getContent()?->getDeepLinkingSettings();
        dd($deeplinking_settings);
        $nonce = Nonce::create(['platform_id' => $instance->platform->id]);
        $url = $instance->platform->authentication_url;
        // $url = "https://udec.test.instructure.com/login/oauth2/token";
        $resource = [
            // "type" => "link",
            // "title" => "This is the default title",
            // "url" => "https://www.google.com"

            "type" => "html",
            "html"=> "<h1>al fin funciona esta shiettttttt</h1>"
        ];
        $payload = [
            "iss" => 'https://lti.cl',
            "aud" => 'https://lti.cl',
            "exp" => time() + 6000,
            "iat" => time(),
            "nonce" => $nonce->value,
            "azp" => 'https://lti.cl',
            "https://purl.imsglobal.org/spec/lti/claim/deployment_id" => $instance->deployment->lti_id,
            "https://purl.imsglobal.org/spec/lti/claim/message_type" => "LtiDeepLinkingResponse",
            "https://purl.imsglobal.org/spec/lti/claim/version" => "1.3.0",
            "https://purl.imsglobal.org/spec/lti-dl/claim/content_items" => [$resource],
            "https://purl.imsglobal.org/spec/lti-dl/claim/data" => [
                "csrftoken:" . $instance->request['state']
            ],
            "presentation" => [
                "documentTarget" => "iframe",
            ]
        ];
        $private_key = config('lti1p3.PRIVATE_KEY');
        $signature_method = config('lti1p3.SIGNATURE_METHOD');
        $kid = config('lti1p3.KID');
        $jwt = JWT::encode($payload, $private_key, $signature_method, $kid);
        $params = ['JWT' => $jwt];
        return View('lti1p3::helpers.autoSubmitForm', ['url' => $url, 'params' => $params]); 
    }

    public function launchConnection(LaunchRequest $request) {
        try{
            if(Launch::isLoginHint($request)) {
                return Launch::attemptLogin($request);
            } else if (Launch::isSuccessfully($request)) {
                    $message = new Message($request->id_token, $request->state);
                    if($message->isDeepLinking()){
                        $instance = Launch::syncDeepLinkingRequest($message);
                        $instance->request = $request->all();
                        $this->auth($instance->user);
                        return $this->onDeepLinkingRequest($instance);
                    }else if($message->isResourceLink()){
                        $instance = Launch::syncResourceLinkRequest($message);
                        $instance->request = $request->all();
                        $this->auth($instance->user);
                        return $this->onResourceLinkRequest($instance);
                    }else{
                        $this->onError("Lti message type is not supported."); 
                    }
            } else {
                return $this->onError();
            }
        }catch(\Exception $exception){
            $this->onError($exception);
        }
    }

    private function auth(User $user) : void {
        if(config('lti1p3.ENABLE_AUTH')){
            Auth::login($user);
        }
    }

    public function jwks(){
        $private_key = config('lti1p3.PRIVATE_KEY');
        $signature_method = config('lti1p3.SIGNATURE_METHOD');
        $kid = config('lti1p3.KID');
        $keys = JWT::buildJWKS($private_key, $signature_method, $kid);
        return response()->json($keys);
    }
}