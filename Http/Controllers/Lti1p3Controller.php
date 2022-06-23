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
use Ramsey\Uuid\Uuid;
use xcesaralejandro\lti1p3\Classes\Message;
use xcesaralejandro\lti1p3\DataStructure\DeepLinkingInstance;
use xcesaralejandro\lti1p3\DataStructure\ResourceLinkInstance;

class Lti1p3Controller {
    public function onResourceLinkRequest(string $instance_id) : mixed {
        $instance = Launch::findInstanceOrFail($instance_id);
        return View('lti1p3::examples.resource_link_request_launched')->with(['instance' => $instance, 'lti1p3.instance_id' => $instance_id]);
    }

    public function onDeepLinkingRequest(string $instance_id) : mixed {
        $instance = Launch::findInstanceOrFail($instance_id);
        return View('lti1p3::examples.deep_linking_request_builder')->with(['lti1p3.instance_id' => $instance_id]);
    }

    public function onError(mixed $exception = null) : mixed {
        return throw new \Exception($exception);
    }

    public function launchConnection(LaunchRequest $request) : mixed {
        try{
            if(Launch::isLoginHint($request)) {
                return Launch::attemptLogin($request);
            } else if (Launch::isSuccessfully($request)) {
                    $message = new Message($request->id_token, $request->state);
                    if($message->isDeepLinking()){
                        $instance = Launch::syncDeepLinkingRequest($message);
                        $instance->request = $request->all();
                        $this->auth($instance->user);
                        $instance_id = Launch::buildInstanceSession($instance);
                        return $this->onDeepLinkingRequest($instance, $instance_id);
                    }else if($message->isResourceLink()){
                        $instance = Launch::syncResourceLinkRequest($message);
                        $instance->request = $request->all();
                        $this->auth($instance->user);
                        $content = $message->getContent();
                        if($content->hasTargetLinkUriRedirection()){
                            redirect($content->getTargetLinkUri());
                        }
                        $instance_id = Launch::buildInstanceSession($instance);
                        return $this->onResourceLinkRequest($instance_id);
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