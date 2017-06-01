<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Access controll interface for Tallinna Kuristiku Gümnaasium">
        <meta name="author" content="Raido Leilop">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>

        <title>{{ config('app.name', 'Access Control') }}</title>

        <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/sb-admin-2.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/font-awesome.css') }}">

        @stack('header')

    </head>

    <body>

        <div id="root">
            @yield('wrapper')
        </div>

        <script src="{{ asset('/js/manifest.js') }}"></script>
        <script src="{{ asset('/js/vendor.js') }}"></script>
        <script src="{{ asset('/js/bundle.js') }}"></script>
        <script src="{{ asset('/js/app.js') }}"></script>

        @stack('scripts')

    </body>

</html>
