<?php

namespace App\Http\Controllers;

use xcesaralejandro\lti1p3\DataStructure\Instance;
use xcesaralejandro\lti1p3\Http\Controllers\Lti1p3Controller;

class LtiController extends Lti1p3Controller {

    public function onLaunch(Instance $instance) : mixed {
        return parent::onLaunch($instance);
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality

        // The onLaunch method is called when the application starts successfully and is a final call.
    }

    public function onError(mixed $exception = null) : mixed {
        return parent::onError($exception);
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality

        // The onError method will be thrown when an invalid connection is attempted, 
        // something goes wrong in the launch process (LMS-LTI). If it is the latter case, 
        // it is most likely due to some problem with the configuration.
        
        // If you're sure you've set everything up correctly and you're still getting errors, 
        // open a github bug, I'll be happy to cry with you for not understanding what's wrong.
    }
}
