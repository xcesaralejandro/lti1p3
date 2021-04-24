<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Support\Facades\Log;
use xcesaralejandro\lti1p3\DataStructure\Instance;
use xcesaralejandro\lti1p3\Facades\JWT;
use xcesaralejandro\lti1p3\Facades\Launch;
use xcesaralejandro\lti1p3\Facades\Lti;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;

class Lti1p3Controller {

    public function onLaunch(Instance $instance) : Mixed 
    {
        return View('lti1p3::welcome')->with(['instance' => $instance]);
    }

    public function onError() : Mixed
    {
        abort(401);
    }

    public function launchConnection(LaunchRequest $request){
        if(Launch::isLoginHint($request)){
            return Launch::attemptLogin($request);
        }else if(Launch::isValidLogin($request)){
            Lti::init($request->id_token, $request->state);
            $platform = Lti::getPlatform();
            $content = Lti::getContent();
            Launch::SyncPlatform($content, $platform);
            $user = Launch::SyncUser($content, $platform->id);
            $context = Launch::SyncContext($content, $platform->id);
            $resourceLink = Launch::SyncResourceLink($content, $context);
            $data = new Instance();
            $data->platform = $platform;
            $data->context = $context;
            $data->resourceLink = $resourceLink;
            $data->user = $user;
            return $this->onLaunch($data);
        }else{
            Log::warning("[Lti1p3Controller] [launchConnection] Launch receive invalid params",
            $request->all());
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