<?php

namespace xcesaralejandro\lti1p3\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class LaunchRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

   
    public function rules() : array
    {
        return [
            'login_hint' => 'nullable|string',
            'iss' => 'required_if:login_hint,1|string',
            'client_id' => 'required_if:login_hint,1|string',
            'target_link_uri' => 'required_if:login_hint,1|string',
            'lti_message_hint' => 'required_if:login_hint,1|string',
            'id_token' => 'required_without:login_hint|string',
            'state' => 'required_if:id_token,1|string'
        ];
    }
}
