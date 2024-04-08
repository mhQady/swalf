<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
        <li class="breadcrumb-item text-sm">
            <a class="opacity-3 text-dark" href="{{ route('dash.home') }}">
                <i class="fa-solid fa-house"></i>
            </a>
        </li>
        @forelse (isset($breads) ? $breads : [] as $bread)
        <li class="breadcrumb-item text-sm ps-0">
            <a class="opacity-5 text-dark" href="{{ $bread['url'] }}">{{ $bread['title'] }}</a>
        </li>
        @empty
        @endforelse
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">@yield('title')</li>
    </ol>
    <h6 class="font-weight-bolder mb-0">@yield('title')</h6>
</nav>