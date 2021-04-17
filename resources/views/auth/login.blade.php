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
        <input type="email" id="email" class="form-control" name="email" />
        <label class="form-label" for="email">
          {{trans('lti1p3::strings.login_email_placeholder')}}
        </label>
      </div>
        
      <div class="form-outline mb-4">
        <input type="password" id="password" class="form-control" name="password" />
        <label class="form-label" for="password">
          {{trans('lti1p3::strings.login_password_placeholder')}}
        </label>
      </div>
        
      <div class="form-check">
        <input class="form-check-input mb-4" type="checkbox" id="remember" 
          name="remember" checked />
        <label class="form-check-label" for="remember">
          {{trans('lti1p3::strings.login_remember_me')}}
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