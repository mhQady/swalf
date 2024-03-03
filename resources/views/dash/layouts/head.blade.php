<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ Vite::img('apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ Vite::img('favicon.png') }}">

    <title>@yield('title', config('app.name'))</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="{{ asset('dashboard/fonts/tajawal/tajawal.css') }}"> --}}
    <link rel="stylesheet" href="{{ vite::asset('resources/dash/fonts/tajawal/tajawal.css') }}">

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    @vite( 'resources/js/dashApp.js')
</head>