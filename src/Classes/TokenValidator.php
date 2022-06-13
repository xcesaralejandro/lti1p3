<?php
namespace xcesaralejandro\lti1p3\Classes;
use Illuminate\Support\Facades\Log;
use App\Models\Platform;

class TokenValidator {
    const Lti1p3 = '1.3.0';

    public static function validOrFail(Content $content, Platform $platform){
        static::assertLti1p3($content);
        static::assertValidJwt($content, $platform);
        static::assertTokenNotExpired($content);
    }

    public static function assertLti1p3(Content $content) : Void {
        $receivedVersion = $content->getLtiVersion();
        if($receivedVersion != self::Lti1p3){
            $message = "The version of lti specified in the token is not supported.";
            throw new \Exception($message);
        }
    }

    public static function assertValidJwt(Content $content, Platform $platform) : Void {
        $hasErrors = false;
        $message = 'Part of the content inside token delivered by the lms does not match with platform configuration.';
        if($platform->issuer_id != $content->getIss()){
            $message = "The platform issuer does not match the token issuer";
            $hasErrors = true;
        }
        if($platform->client_id != $content->getAud()){
            $message = "The platform client_id does not match the token audience";
            $hasErrors = true;
        }
        $registered_deployment_ids = $platform->deployments->pluck('lti_id')->toArray();
        if(!in_array($content->getDeploymentId(), $registered_deployment_ids) && !$platform->deployment_id_autoregister){
            $message = "The deployment_id that is being launched is not registered and the automatic registration of new deployment_id is disabled for the platform.";
            $hasErrors = true;
        }
        if($hasErrors){
            throw new \Exception($message);
        }
    }

    public static function assertTokenNotExpired(Content $content){
        if($content->tokenIsExpired()){
            $message = "The JWT recived is expired.";
            throw new \Exception($message);
        }
    }

}
