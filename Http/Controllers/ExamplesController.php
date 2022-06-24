<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Http\Request;
use xcesaralejandro\lti1p3\Classes\DeepLinkingResponse;
use xcesaralejandro\lti1p3\DataStructure\DeepLinkingInstance;
use xcesaralejandro\lti1p3\Models\Nonce;


class ExamplesController {

    public function showContent(Request $request){
        $response = new DeepLinkingResponse($request->lti1p3_instance);
        return $response->submit();
        // return $this->deepLinkingForCreateResource($instance);
    }

    public function deepLinkingForCreateResource(DeepLinkingInstance $instance): mixed {
        $deeplinking_settings = $instance->message->getContent()?->getDeepLinkingSettings();
        $nonce = Nonce::create(['platform_id' => $instance->platform->id]);
        $url = $deeplinking_settings->deep_link_return_url;
        $resource = [[
                    "type" => "ltiResourceLink",
                    "title" => "This is the default title for TESTTTTTTTTTTTTTTTTTTTT",
                    "url" => "https://lti.cl?custom_resource_with_id=1000",
                    "presentation" => [
                        "documentTarget" => "iframe",
                    ]
                ]
        ];
        $payload = [
            "iss" => $instance->platform->client_id,
            "aud" => $instance->platform->issuer_id,
            "exp" => time() + 6000,
            "iat" => time() - 100,
            "nonce" => $nonce->value,
            "https://purl.imsglobal.org/spec/lti/claim/deployment_id" => $instance->deployment->lti_id,
            "https://purl.imsglobal.org/spec/lti/claim/message_type" => "LtiDeepLinkingResponse",
            "https://purl.imsglobal.org/spec/lti/claim/version" => "1.3.0",
            "https://purl.imsglobal.org/spec/lti-dl/claim/content_items" => $resource,
            "https://purl.imsglobal.org/spec/lti-dl/claim/data" => $deeplinking_settings->deep_link_return_url,
        ];
        $private_key = config('lti1p3.PRIVATE_KEY');
        $signature_method = config('lti1p3.SIGNATURE_METHOD');
        $kid = config('lti1p3.KID');
        $jwt = JWT::encode($payload, $private_key, $signature_method, $kid);
        $params = ['JWT' => $jwt];
        return View('lti1p3::helpers.autoSubmitForm', ['url' => $url, 'params' => $params]); 
    }
}