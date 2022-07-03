<?php
 
namespace xcesaralejandro\lti1p3\Http\Middleware;
 
use Closure;
use xcesaralejandro\lti1p3\Facades\Launch;
use App\Models\Instance;

class InstanceRecovery
{
    public function handle($request, Closure $next){
        if(isset($request->lti1p3_instance_id)){
            $instance = Instance::RecoveryFromId($request->lti1p3_instance_id);
            $request->merge(['lti1p3_instance' => $instance]);
        }
        return $next($request);
    }
}