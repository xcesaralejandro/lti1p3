<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use xcesaralejandro\lti1p3\DataStructure\Instance;
use xcesaralejandro\lti1p3\Facades\JWT;
use xcesaralejandro\lti1p3\Facades\Launch;
use xcesaralejandro\lti1p3\Facades\Lti;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;
use xcesaralejandro\lti1p3\Models\Nonce;
use xcesaralejandro\lti1p3\Models\User;
use GuzzleHttp\Psr7\Request;


class Lti1p3Controller {
    public function onLaunch(Instance $instance) : mixed {
        return $this->deepLinkingForCreateResource($instance);
        return View('lti1p3::welcome')->with(['instance' => $instance]);
    }

    public function deepLinkingForCreateResource(Instance $instance): mixed {
        $nonce = Nonce::create(['platform_id' => $instance->platform->id]);
        $url = $instance->platform->authentication_url;
        $payload = json_encode([
            'iss' => 'https://lti.cl',
            'sub' => $instance->platform->client_id,
            'aud' => $url,
            'exp' => time() + 6000,
            'iat' => time(),
            // 'azp' => $instance->platform->client_id,
            'nonce' => $nonce->value,
            'name' => $instance->user->name,
            'given_name' => $instance->user->given_name,
            'family_name' => $instance->user->family_name,
            'picture' => $instance->user->picture,
            'email' => $instance->user->email,
           // 'locale' => $instance->user->locale,
            'https://purl.imsglobal.org/spec/lti/claim/deployment_id' => $instance->deployment->lti_id,
            'https://purl.imsglobal.org/spec/lti/claim/message_type' => 'LtiDeepLinkingRequest',
            'https://purl.imsglobal.org/spec/lti/claim/version' => "1.3.0",
            // 'https://purl.imsglobal.org/spec/lti/claim/roles' : $instance->user->roles,
            'https://purl.imsglobal.org/spec/lti/claim/context' =>  json_encode((object) [
                'id' => $instance->context->lti_id,
                'label' => $instance->context->label,
                'title' => $instance->context->title,
                'type' => [$instance->context->type],
            ]),
            'https://purl.imsglobal.org/spec/lti/claim/tool_platform' => json_encode((object) [
                'contact_email' => 'cmora@gmail.com',
                'description' => 'custom lti',
                'name' => 'test lti',
                'url' => 'https://lti.cl',
                'product_family_code' => 'mi_lti',
                'version' => '1',
            ]),
            'https://purl.imsglobal.org/spec/lti-dl/claim/deep_linking_settings' => json_encode((object) [
                'deep_link_return_url' => 'https://www.google.com',
                'accept_types' => ["link", "file", "html", "ltiResourceLink", "image"],
                'accept_media_types' => "image/*,text/html",
                'accept_presentation_document_targets' => ["iframe", "window", "embed"],
                'accept_multiple' => true,
                'auto_create' => true,
                'title' => 'This is the default title',
                'text' => 'This is the default text',
                'data' => 'csrftoken:{$instance->request["state"]}',
            ])  
        ]);
        $request = new Request('POST', $url, [], $payload);
        dd($request->getBody()->getContents());
        // dd($payload);
        // $form = ['url' => $url, 'params' => $payload];
        // return View('lti1p3::helpers.autoSubmitForm', $form); 
    }

    public function onError(mixed $exception = null) : mixed {
        return throw new \Exception($exception);
    }

    public function launchConnection(LaunchRequest $request) {
        if(Launch::isLoginHint($request)) {
            try{
                return Launch::attemptLogin($request);
            }catch(\Exception $exception){
                $this->onError($exception);
            }
        }else if (Launch::isSuccessfulLoginAttempt($request)) {
            try{
                Lti::init($request->id_token, $request->state);
                $platform = Lti::getPlatform();
                $content = Lti::getContent();
                $instance = Launch::syncAll($content, $platform);
                $instance->request = $request->all();
                if(config('lti1p3.ENABLE_AUTH')){
                    Auth::login($instance->user);
                }
                return $this->onLaunch($instance);
            }catch(\Exception $exception){
                $this->onError($exception);
            }
        } else {
            return $this->onError();
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