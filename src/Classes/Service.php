<?php

namespace xcesaralejandro\lti1p3\Classes;
use xcesaralejandro\lti1p3\DataStructure\Instance;

class Service {

    protected Instance $instance;
    
    public function init(Instance $instance){
        $this->instance = $instance;
    }

    public function refreshInstance(Instance $instance){
        $this->instance = $instance;
    }

}