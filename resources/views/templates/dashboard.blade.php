<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/dashboard.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/lti1p3-styles.css')}}" rel="stylesheet" type="text/css"/>
    @stack('css')
    <link href="{{asset('css/lti1p3_styles.css')}}" rel="stylesheet" type="text/css"/>
    <title>{{trans('lti1p3::lti1p3.app_name')}}</title>
</head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3">{{trans('lti1p3::lti1p3.app_name')}}</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="{{route('lti1p3.auth.logout')}}">
        {{trans('lti1p3::lti1p3.navbar_logout')}}
      </a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    @include('lti1p3::templates.navbar')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      </div>
      @yield('content')
    </main>
  </div>
</div>


<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dashboard.js')}}"></script>
@stack('js')
  </body>
</html>
