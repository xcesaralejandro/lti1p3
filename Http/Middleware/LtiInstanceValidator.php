<?php

namespace xcesaralejandro\lti1p3\Http\Middleware;

use Closure;
use App\Models\LtiInstance;
use Illuminate\Support\Facades\Auth;

class LtiInstanceValidator
{
    public function handle($request, Closure $next){
        $instance_id = $request->lti1p3_instance_id
                    ?? $request->header('lti1p3_instance_id')
                    ?? $request->route('lti1p3_instance_id');
        if (empty($instance_id)) {
            abort(401, 'Unauthorized: Missing instance ID.');
        }
        $instance = LtiInstance::find($instance_id);
        if (empty($instance) || $instance->isExpired()) {
            abort(401, 'Unauthorized: Invalid or expired instance.');
        }
        $request->merge(['lti1p3_instance' => $instance]);
        Auth::login($instance->user, true);
        return $next($request);
    }
}
