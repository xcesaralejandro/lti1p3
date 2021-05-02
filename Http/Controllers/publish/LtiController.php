<?php

namespace App\Http\Controllers;

use xcesaralejandro\lti1p3\DataStructure\Instance;
use xcesaralejandro\lti1p3\Http\Controllers\Lti1p3Controller;

class LtiController extends Lti1p3Controller {

    public function onLaunch(Instance $instance) : mixed {
        return parent::onLaunch($instance);
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality
    }

    public function onError() : mixed {
        return parent::onError();
        // Do something, here it is not necessary to call the parent function,
        // it is only to maintain the example functionality
    }
}
