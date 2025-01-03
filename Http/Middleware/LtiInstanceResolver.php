<?php

namespace xcesaralejandro\lti1p3\Http\Middleware;

use Closure;
use App\Models\LtiInstance;

class LtiInstanceResolver
{
    public function handle($request, Closure $next){
        $instance_id = $request->input('lti1p3_instance_id')
                    ?? $request->header('lti1p3_instance_id')
                    ?? $request->route('lti1p3_instance_id');
        if(!empty($instance_id)){
            $instance = LtiInstance::find($instance_id);
            $request->merge(['lti1p3_instance' => $instance]);
        }
        return $next($request);
    }
}
