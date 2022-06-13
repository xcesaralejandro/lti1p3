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
            "local_name" => "required",
            "issuer_id" => "required",
            "client_id" => "required",
            "authorization_url" => "required",
            "authentication_url" => "required",
            "json_webkey_url" => "required",
            "signature_method" => "required",
            "lti_advantage_token_url" => "nullable"
        ];
    }
}
