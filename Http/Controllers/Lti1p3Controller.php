<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use xcesaralejandro\lti1p3\DataStructure\Instance;
use xcesaralejandro\lti1p3\Facades\JWT;
use xcesaralejandro\lti1p3\Facades\Launch;
use xcesaralejandro\lti1p3\Facades\Lti;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;
use xcesaralejandro\lti1p3\Models\User;

class Lti1p3Controller {
    public function onLaunch(Instance $instance) : mixed {
        return View('lti1p3::welcome')->with(['instance' => $instance]);
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