<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/lti1p3-styles.css') }}" rel="stylesheet" type="text/css" />
    @stack('css')
    <link href="{{ asset('css/lti1p3_styles.css') }}" rel="stylesheet" type="text/css" />
    <title>{{ trans('lti1p3::lti1p3.app_name') }}</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row no-gutters">
            @include('lti1p3::templates.navbar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
                @yield('content')
            </main>
        </div>
    </div>
    <script type="text/javascript" src="{{ asset('js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dashboard.js') }}"></script>
    @stack('js')
</body>

</html>
