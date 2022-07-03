<?php

namespace xcesaralejandro\lti1p3\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class NewDeploymentRequest extends FormRequest
{
    public function authorize() : bool
    {
        return true;
    }

   
    public function rules() : array
    {
        return [
            "lti_id" => "required",
            "target_link_uri" => "nullable|max:255"
        ];
    }
}
