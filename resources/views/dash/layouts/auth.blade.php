<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    @include('dash.layouts.head')

    <body>
        <main class="main-content mt-0">
            @yield('content')
        </main>
    </body>

</html>