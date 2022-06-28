<?php 
namespace xcesaralejandro\lti1p3\Http\Controllers;

use Illuminate\Http\Request;
use xcesaralejandro\lti1p3\Classes\DeepLinkingResponse;
use xcesaralejandro\lti1p3\DataStructure\DeepLinkingInstance;
use xcesaralejandro\lti1p3\Models\Nonce;


class ExamplesController {

    public function SendDeepLinkingMessage(Request $request){
        $launch_at = route('deep_linking.example.view', ['lti1p3_instance_id' => $request->lti1p3_instance_id, 'title' => $request->title, 
        'description' => $request->description, 'custom' => $request->custom]);
        $deep_linking_response = new DeepLinkingResponse($request->lti1p3_instance);
        $content_item = [
            "type" => "ltiResourceLink", 
            "title" => $request->title, 
            "text" => $request->description,
            "url" => $launch_at,
            "presentation" => ["documentTarget" => "iframe"]
        ];
        $deep_linking_response->addContentItem($content_item);    
        return View('lti1p3::helpers.autoSubmitForm', $deep_linking_response->get()); 
    }

    public function launchDeepLinkingUrl(Request $request) : mixed {
        return View('lti1p3::examples.deep_linking_request_visualizer', $request->all());
    }

}