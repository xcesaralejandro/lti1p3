<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use xcesaralejandro\lti1p3\Facades\Launch;
use xcesaralejandro\lti1p3\Http\Requests\LaunchRequest;

class Lti1p3Controller {

    public function launchConnection(LaunchRequest $request){
        dd(Launch::hello());
    }
}