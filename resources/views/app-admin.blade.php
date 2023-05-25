<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <link rel="icon" type="image/png" href="{{url('/images/favicon.png')}}" />
        <title inertia>{{ config('app.name', 'Eurekapage') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
        <script charset="utf-8" type="text/javascript" src="https://js.hsforms.net/forms/embed/v2.js"></script>
        @if (request()->segment(1) == 'backend' && request()->segment(2) == 'login')
        <script src="https://www.google.com/recaptcha/api.js?render=6Ld3PBImAAAAAA_zzdnsOCw81mZHo6h_zODHtDFQ"></script>
        @endif
        <!-- Scripts -->
        @routes
         @vite(['resources/js/admin.js', "resources/js/Admin/{$page['component']}.vue"])
        @inertiaHead
    </hsead>
    <body class="font-sans antialiased  bg-lightgrey">
        @inertia
    </body>


</html>
