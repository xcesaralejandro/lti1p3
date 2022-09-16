<?php

namespace xcesaralejandro\lti1p3\Http\Middleware;

use Closure;
use xcesaralejandro\lti1p3\Facades\Launch;
use App\Models\Instance;

class InstanceRecovery
{
    public function handle($request, Closure $next){
        $from_params = $request->lti1p3_instance_id ?? null;
        $from_headers = $request->header('lti1p3-instance-id');
        $instance_id = $from_headers ?? $from_params;
        if(!empty($instance_id)){
            $instance = Instance::RecoveryFromId($instance_id);
            if($instance->isExpired()){
                abort(401);
            }
            $request->merge(['lti1p3_instance' => $instance]);
        }
        return $next($request);
    }
}
