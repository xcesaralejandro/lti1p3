<?php 
namespace xcesaralejandro\lti1p3\Facades;

use Illuminate\Support\Facades\Facade;

class Lti extends Facade {
    protected static function getFacadeAccessor(){
        return 'lti';
    }
}