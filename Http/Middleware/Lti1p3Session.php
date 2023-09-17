<?php

namespace xcesaralejandro\lti1p3\Http\Middleware;

use Closure;
use App\Models\Instance;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Lti1p3Session
{
    public function handle($request, Closure $next){
        if(Session::has('lti1p3_session')){
            return $next($request);
        }else{
            abort(401);
        }
    }
}
