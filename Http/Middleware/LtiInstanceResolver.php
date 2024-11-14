<?php

namespace xcesaralejandro\lti1p3\Http\Middleware;

use Closure;
use App\Models\LtiInstance;

class LtiInstanceResolver
{
    public function handle($request, Closure $next){
        $from_params = $request->{"lti1p3-instance-id"} ?? null;
        $from_headers = $request->header('lti1p3-instance-id');
        $instance_id = $from_headers ?? $from_params;
        if(!empty($instance_id)){
            try{
                $instance = LtiInstance::findOrFail($instance_id);
            }catch(\Exception $e){
            }
            $request->merge(['lti1p3_instance' => $instance]);
        }
        return $next($request);
    }
}
