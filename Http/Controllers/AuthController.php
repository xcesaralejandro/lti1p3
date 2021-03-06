<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController {

    public function index(){
        if(Auth::check()){
            return redirect()->route('lti1p3.platforms.index');
        }
        return View('lti1p3::auth.login');
    }

    public function attemp(Request $request){
        $request->validate([
            'email' => 'required|email|min:5',
            'password' => 'required|string|min:6',
            'remember' => 'sometimes|string'
        ]);
        $credentials = $request->only(['email', 'password']);
        $remember = $request->remember ?? null;
        $valid_attempt = Auth::attempt($credentials, $remember);
        if($valid_attempt && Auth::user()->isToolAdmin()){
            return redirect()->route('lti1p3.platforms.index');
        } else {
            Auth::logout();
            Session::flush();
            return redirect()->route('lti1p3.auth')->withErrors(['Attemp' => 'failed']);
        }
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}