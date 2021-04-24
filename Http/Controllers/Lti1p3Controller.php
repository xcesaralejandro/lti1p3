<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use xcesaralejandro\lti1p3\Facades\JWT;
use xcesaralejandro\lti1p3\Facades\Launch;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;

class Lti1p3Controller {

    public function launchConnection(LaunchRequest $request){
        dd(Launch::hello());
    }

    public function showJwks(){
        $private_key = config('lti1p3.PRIVATE_KEY');
        $signature_method = config('lti1p3.SIGNATURE_METHOD');
        $kid = config('lti1p3.KID');
        $keys = JWT::buildJWKS($private_key, $signature_method, $kid);
        return response()->json($keys);
    }
}