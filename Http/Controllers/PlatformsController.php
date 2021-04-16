<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PlatformsController {

    public function index(){
        return View('lti1p3::admin.platforms');
    }
}