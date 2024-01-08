@extends('lti1p3::templates.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 bg-white border rounded p-3">
            <h2 class="h6 mb-4">
                {{trans('lti1p3::lti1p3.platform_new_platform_title')}}
            </h2>
            @if(isset($wasCreated))
                <div class="alert alert-success mt-3 p-2" role="alert">
                    {{trans('lti1p3::lti1p3.platform_create_success')}}
                </div>
            @endif
            <form action="{{route('lti1p3.platforms.store')}}" method="post">
                @csrf
                <div class="form-floating mb-3 mt-2">
                    <input type="text" id="local_name" name="local_name" class="form-control" required/>
                    <label class="form-label" for="local_name">
                        {{trans('lti1p3::lti1p3.platform_local_name_label')}}
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" id="issuer_id" name="issuer_id" class="form-control" 
                        required/>
                    <label class="form-label" for="issuer_id">
                        {{trans('lti1p3::lti1p3.platform_issuer_id_label')}}
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" id="client_id" name="client_id" class="form-control" 
                        required/>
                    <label class="form-label" for="client_id">
                        {{trans('lti1p3::lti1p3.platform_client_id_label')}}
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" id="lti_advantage_token_url" name="lti_advantage_token_url"
                        class="form-control" />
                    <label class="form-label" for="lti_advantage_token_url">
                        {{trans('lti1p3::lti1p3.platform_lti_advantage_token_url_label')}}
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" id="authorization_url" name="authorization_url"
                        class="form-control" required />
                    <label class="form-label" for="authorization_url">
                        {{trans('lti1p3::lti1p3.platform_authorization_url_label')}}
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" id="authentication_url" name="authentication_url" 
                        class="form-control" required />
                    <label class="form-label" for="authentication_url">
                        {{trans('lti1p3::lti1p3.platform_authentication_url_label')}}
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" id="json_webkey_url" name="json_webkey_url"
                        class="form-control" required />
                    <label class="form-label" for="json_webkey_url">
                        {{trans('lti1p3::lti1p3.platform_json_webkey_url_label')}}
                    </label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" id="signature_method" name="signature_method"
                        value="RS256" class="form-control" required />
                    <label class="form-label" for="signature_method">
                        {{trans('lti1p3::lti1p3.platform_signature_method_label')}}
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="deployment_id_autoregister" type="checkbox" checked="checked">
                    <label class="form-check-label" for="flexCheckDefault">
                      {{trans('lti1p3::lti1p3.platform_deployment_id_autoregister_label')}}
                    </label>
                </div>
                @if($errors->any())
                <div class="alert alert-danger mt-3 py-1" role="alert">
                    {{trans('lti1p3::lti1p3.platform_create_error')}}
                </div>
                @endif
                <div class="d-flex justify-content-end">
                    <input type="submit" class="btn btn-outline-primary mt-3" 
                        value="{{trans('lti1p3::lti1p3.save_button')}}"/>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection