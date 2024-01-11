@extends('lti1p3::templates.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 bg-white border rounded p-3">
            <h2 class="h6 mb-4">
                {{trans('lti1p3::lti1p3.platform_new_platform_title')}}
            </h2>
            @if(isset($wasUpdated))
                <div class="alert alert-success mt-3 p-2" role="alert">
                    {{trans('lti1p3::lti1p3.platform_config_change_success')}}
                </div>
            @endif
            <form action="{{route('lti1p3.platforms.update', [$platform->id])}}" method="post">
                @csrf
                @method('PUT')
                @include('lti1p3::admin.platforms.forms.createOrUpdate')
                @if($errors->any())
                <div class="alert alert-danger mt-3 py-1" role="alert">
                    {{trans('lti1p3::lti1p3.platform_create_error')}}
                </div>
                @endif
                <div class="d-flex justify-content-end">
                    <input type="submit" class="btn btn-primary mt-3" 
                        value="{{trans('lti1p3::lti1p3._update')}}"/>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection