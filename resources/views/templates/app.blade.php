<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{asset('css/mdb.min.css')}}" rel="stylesheet" type="text/css"/>
    @stack('css')
    <link href="{{asset('css/styles.css')}}" rel="stylesheet" type="text/css"/>
    <title>{{trans('lti1p3::strings.app_name')}}</title>
</head>
<body>
    <header>
        @yield('header')
    </header>
    <div class="container">
        @yield('content')
    </div>
    <footer>
        @yield('footer')
    </footer>
    <script type="text/javascript" src="{{asset('js/mdb.min.js')}}"></script>
    @stack('js')
</body>
</html>