<?php 
namespace xcesaralejandro\lti1p3\Facades;

use Illuminate\Support\Facades\Facade;

class Launch extends Facade {
    protected static function getFacadeAccessor(){
        return 'launch';
    }
}