<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ Vite::img('apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ Vite::img('favicon.png') }}">

    <title>@yield('title', config('app.name'))</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="{{ asset('dash/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dash/datatables.js') }}"></script>
    <script src="{{ asset('dash/choices.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    @vite( 'resources/js/dashApp.js')
    @stack('styles')
</head>