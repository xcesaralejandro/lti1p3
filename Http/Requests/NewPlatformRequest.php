<?php

namespace xcesaralejandro\lti1p3\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class NewPlatformRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

   
    public function rules() : array
    {
        return [
            "record_name" => "required",
            "issuer_id" => "required",
            "client_id" => "required",
            "deployment_id" => "required",
            "authorization_url" => "required",
            "authentication_url" => "required",
            "json_webkey_url" => "required",
            "signature_method" => "required"
        ];
    }
}
