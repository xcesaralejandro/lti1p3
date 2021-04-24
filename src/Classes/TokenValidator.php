<?php
namespace xcesaralejandro\lti1p3\Classes;
use Illuminate\Support\Facades\Log;
use xcesaralejandro\lti1p3\Models\Platform;

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
            Log::error('[LtiTokenValidator::class] '.$message,
            ['receivedVersion' => $receivedVersion]);
            throw new \Exception($message);
        }
    }

    public static function assertValidJwt(Content $content, Platform $platform) : Void {
        $hasErrors = false;
        if($platform->issuer_id != $content->getIss()){
            $message = "The platform issuer does not match the token issuer";
            Log::error('[LtiTokenValidator::class] '.$message,
            ['platform' => $platform->issuer_id, 'content'=>$content->getIss()]);
            $hasErrors = true;
        }
        if($platform->client_id != $content->getAud()){
            $message = "The platform client_id does not match the token audience";
            Log::error('[LtiTokenValidator::class] '.$message,
            ['platform' => $platform->client_id, 'content'=>$content->getAud()]);
            $hasErrors = true;
        }
        if($platform->deployment_id != $content->getDeploymentId()){
            $message = "The platform deployment_id does not match the token deployment_id";
            Log::error('[LtiTokenValidator::class] '.$message,
            ['platform' => $platform->deployment_id, 'content'=>$content->getDeploymentId()]);
            $hasErrors = true;
        }
        if($hasErrors){
            $message = 'The content of JWT does not match with platform';
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
