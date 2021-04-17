@extends('lti1p3::templates.app')

@section('header')
    @include('lti1p3::templates.navbar')
@endsection

@section('content')
<div class="navbar-height-spacing"></div>
<div class="mt-3 p-3 row">
    <div class="col-md-8 offset-md-2 bg-white border p-3">
        <h3>
            {{trans('lti1p3::strings.platform_new_platform_title')}}
        </h3>
        <hr>
        @if(isset($wasCreated))
            <div class="alert alert-success mt-3 py-1" role="alert">
                {{trans('lti1p3::strings.platform_create_success')}}
            </div>
        @endif
        <form action="{{route('lti1p3.platforms.store')}}" method="post">
            @csrf
            <div class="form-outline mb-3">
                <input type="text" id="record_name" name="record_name" class="form-control" 
                    required/>
                <label class="form-label" for="record_name">
                    {{trans('lti1p3::strings.platform_record_name_label')}}
                </label>
            </div>
            <div class="form-outline mb-3">
                <input type="text" id="issuer_id" name="issuer_id" class="form-control" 
                    required/>
                <label class="form-label" for="issuer_id">
                    {{trans('lti1p3::strings.platform_issuer_id_label')}}
                </label>
            </div>
            <div class="form-outline mb-3">
                <input type="text" id="client_id" name="client_id" class="form-control" 
                    required/>
                <label class="form-label" for="client_id">
                    {{trans('lti1p3::strings.platform_client_id_label')}}
                </label>
            </div>
            <div class="form-outline mb-3">
                <input type="text" id="deployment_id" name="deployment_id" class="form-control" 
                    required/>
                <label class="form-label" for="deployment_id">
                    {{trans('lti1p3::strings.platform_deployment_id_label')}}
                </label>
            </div>
            <div class="form-outline mb-3">
                <input type="text" id="authorization_url" name="authorization_url"
                    class="form-control" required />
                <label class="form-label" for="authorization_url">
                    {{trans('lti1p3::strings.platform_authorization_url_label')}}
                </label>
            </div>
            <div class="form-outline mb-3">
                <input type="text" id="authentication_url" name="authentication_url" 
                    class="form-control" required />
                <label class="form-label" for="authentication_url">
                    {{trans('lti1p3::strings.platform_authentication_url_label')}}
                </label>
            </div>
            <div class="form-outline mb-3">
                <input type="text" id="json_webkey_url" name="json_webkey_url"
                    class="form-control" required />
                <label class="form-label" for="json_webkey_url">
                    {{trans('lti1p3::strings.platform_json_webkey_url_label')}}
                </label>
            </div>
            <div class="form-outline">
                <input type="text" id="signature_method" name="signature_method"
                    value="RS256" class="form-control" required />
                <label class="form-label" for="signature_method">
                    {{trans('lti1p3::strings.platform_signature_method_label')}}
                </label>
            </div>
            @if($errors->any())
            <div class="alert alert-danger mt-3 py-1" role="alert">
                {{trans('lti1p3::strings.platform_create_error')}}
            </div>
            @endif
            <input type="submit" class="btn btn-outline-primary mt-3" 
                value="{{trans('lti1p3::strings.platform_save_button')}}"/>
        </form>
    </div>
</div>
@endsection