<?php

namespace App\Http\Controllers;

use xcesaralejandro\lti1p3\DataStructure\Instance;
use xcesaralejandro\lti1p3\Http\Controllers\Lti1p3Controller;

class LtiController extends Lti1p3Controller {

    /*

        Important!
        Consider that an LTI can be added on multiple sides, 
        sometimes your LTI can receive LtiResourceLinkRequest and LtiDeepLinkingRequest triggers

    */

    public function onResourceLinkRequest(string $instance_id) : mixed {
        return parent::onResourceLinkRequest($instance_id);
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality

        // This method is called when the lti launch is of type LtiResourceLinkRequest
        // You can read about it here: http://www.imsglobal.org/spec/lti/v1p3/#resource-link-launch-request-message

        // In human words, it is the launch of the LTI after doing the validations behind the scenes and the synchronization 
        // of the data that arrives from the LMS with the local platform (The one that you must now start developing). 
        // Sometimes this launch can be skipped by a custom redirect if you defined it in the LMS or it is a LtiDeepLinkingRequest.
    }

    public function onDeepLinkingRequest(string $instance_id) : mixed {
        return parent::onDeepLinkingRequest($instance_id);
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality

        // This method is called when the lti launch is of type LtiDeepLinkingRequest
        // You can read about it here: https://www.imsglobal.org/spec/lti-dl/v2p0#overview

        // In human words, it is the launch of the LTI when it comes to DeepLinking. This, depending on the location where you add your LTI, 
        // allows you to generate custom resources, return tasks, among other things.
        // I recommend reading the specification because to date I haven't tested everything it allows (UPS!).

        // In such a launch you must reply back to the LMS with a DeepLinking message to end the cycle.
        // You can browse the original model to review how the example works.
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
