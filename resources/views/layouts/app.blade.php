<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="eQonaq – специализированная информационная система для взаимодействия мест размещения, иностранных туристов и государственных органов.">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Специализированная информационная система  «eQonaq»</title>
    <!-- Scripts -->
    {{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/materialize.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i,900&display=swap&subset=cyrillic" rel="stylesheet">
    <!--Import materialize.css-->

<!--Let browser know website is optimized for mobile-->
</head>
{{--<script type="text/javascript" src="js/bin/jquery-3.3.1.min.js"></script>--}}

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script type="text/javascript" src="js/bin/materialize.min.js"></script>

<script type="text/javascript" src="js/bin/main.min.js"></script>
<body>
@yield('content')

<!--JavaScript at end of body for optimized loading-->

</body>

</html>
