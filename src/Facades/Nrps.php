<?php 
namespace xcesaralejandro\lti1p3\Facades;

use Illuminate\Support\Facades\Facade;

class Nrps extends Facade {
    protected static function getFacadeAccessor(){
        return 'nrps-service';
    }
}