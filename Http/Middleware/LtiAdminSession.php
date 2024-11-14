<?php

namespace xcesaralejandro\lti1p3\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class LtiAdminSession
{
    public function handle($request, Closure $next){
        if(Session::has('lti1p3_admin_session')){
            return $next($request);
        }else{
            abort(401);
        }
    }
}
