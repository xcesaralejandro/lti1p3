<?php

namespace xcesaralejandro\lti1p3\Http\Middleware;

use Closure;
use App\Models\Instance;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class InstanceRecovery
{
    public function handle($request, Closure $next){
        $from_params = $request->{"lti1p3-instance-id"} ?? null;
        $from_headers = $request->header('lti1p3-instance-id');
        $instance_id = $from_headers ?? $from_params;
        if(!empty($instance_id)){
            try{
                $instance = Instance::RecoveryFromId($instance_id);
            }catch(ModelNotFoundException $e){
                abort(401);
            }
            if($instance->isExpired()){
                abort(401);
            }
            $request->merge(['lti1p3_instance' => $instance]);
            Auth::login($request->lti1p3_instance->user, true);
        }else{
            abort(401);
        }
        return $next($request);
    }
}
