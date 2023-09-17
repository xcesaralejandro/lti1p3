<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController {

    public function index(){
        if(Session::has('lti1p3_session')){
            return redirect()->route('lti1p3.platforms.index');
        }
        return View('lti1p3::auth.login');
    }

    public function attemp(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $user = config('lti1p3.LTI1P3_ADMIN_USERNAME');
        $password = config('lti1p3.LTI1P3_ADMIN_PASSWORD');
        $valid_attempt = $request->username == $user && $request->password == $password;
        if($valid_attempt){
            Session::put('lti1p3_session', time());
            return redirect()->route('lti1p3.platforms.index');
        } else {
            Session::flush();
            return redirect()->route('lti1p3.auth')->withErrors(['Attemp' => 'failed']);
        }
    }

    public function logout(){
        Session::flush();
        return redirect('/');
    }
}