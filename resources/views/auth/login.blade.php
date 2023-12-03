@extends('lti1p3::templates.app')

@section('content')
<div class="row py-5 p-4">
  <div class="col-md-6 offset-md-3 col-xl-4 offset-xl-4 p-3 border bg-blue-500 pb-3 bg-white">
    <h3 class="pt-2 pb-2">
        {{trans('lti1p3::lti1p3.login_title')}}
    </h3>
    <form method="post" action="{{route('lti1p3.auth.attemp')}}">
      @csrf
      <div class="form-outline mb-4">
        <label class="form-label" for="username">
          {{trans('lti1p3::lti1p3.login_username_placeholder')}}
        </label>
        <input type="text" id="username" class="form-control" name="username" />
      </div>
        
      <div class="form-outline mb-4">
        <label class="form-label" for="password">
          {{trans('lti1p3::lti1p3.login_password_placeholder')}}
        </label>
        <input type="password" id="password" class="form-control" name="password" />
      </div>
        
      @if($errors->any())
      <div class="alert alert-danger mt-4 py-1" role="alert">
        {{trans('lti1p3::lti1p3.login_attemp_failed')}}
      </div>
      @endif
        
      <button type="submit" class="btn btn-primary btn-block w-100">
        {{trans('lti1p3::lti1p3.login_button')}}
      </button>
    </form>
  </div>
</div>
@endsection