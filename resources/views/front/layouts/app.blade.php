<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', $title ?? config('app.name', "e-Bidding"))</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        @stack('css')
    </head>
    <body class="@yield('bodyClass')">
        <div style="min-height: 100vh;display: flex;flex-direction:column;justify-content:space-between">
            @include('front.layouts.header')

           <div style="flex: 1">
            @yield('content')
           </div>

            @include('front.layouts.footer')
        </div>

        <!-- Script -->
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        @stack('js')
    </body>
</html>
