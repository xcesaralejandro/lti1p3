<?php
namespace xcesaralejandro\lti1p3\Classes;

use App\Models\Instance;

class DeepLinkingResponse {
   
    function __construct(Instance $instance){
        $this->instance = $instance;
    }

    public function submit(){
        dd("Instance", $this->instance);
        return "";
    }
}
