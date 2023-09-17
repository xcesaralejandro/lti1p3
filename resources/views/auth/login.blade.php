@extends('lti1p3::templates.app')

@section('content')
<div class="row py-5">
  <div class="col-md-4 offset-md-4 p-3 border bg-blue-500 pt-5 pb-3 bg-white">
    <h3 class="pt-2 pb-2">
        {{trans('lti1p3::strings.login_title')}}
    </h3>
    <form method="post" action="{{route('lti1p3.auth.attemp')}}">
      @csrf
      <div class="form-outline mb-4">
        <input type="text" id="username" class="form-control" name="username" />
        <label class="form-label" for="username">
          {{trans('lti1p3::strings.login_username_placeholder')}}
        </label>
      </div>
        
      <div class="form-outline mb-4">
        <input type="password" id="password" class="form-control" name="password" />
        <label class="form-label" for="password">
          {{trans('lti1p3::strings.login_password_placeholder')}}
        </label>
      </div>
        
      @if($errors->any())
      <div class="alert alert-danger mt-4 py-1" role="alert">
        {{trans('lti1p3::strings.login_attemp_failed')}}
      </div>
      @endif
        
      <button type="submit" class="btn btn-primary btn-block">
        {{trans('lti1p3::strings.login_button')}}
      </button>
    </form>
  </div>
</div>
@endsection