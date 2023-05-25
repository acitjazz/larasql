<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" type="image/png" href="{{url('/images/favicon.png')}}" />
        <title inertia>{{ config('app.name', 'Eurekapage') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

        @routes
        <script>
            Ziggy.url = '{{ env('APP_URL') }}'
        </script>
         @vite(['resources/js/app.js', "resources/js/Frontend/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-primary antialiased bg-[#D1D1D1]">
        @inertia

    </body>
</html>
