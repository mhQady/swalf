<aside @class(["sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3
    bg-white", "fixed-start ms-3"=>
    app()->getLocale() == 'en', "fixed-end me-3" => app()->getLocale() == 'ar'])
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dash.home') }}">
            {{-- <img src="../../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo"> --}}
            <span class="ms-1 font-weight-bold">{{ config('app.name') }}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav p-0">
            @can('browse interest')
            <li class="nav-item">
                <a @class(['nav-link', 'active'=> request()->routeIs('dash.interests*')])
                    href="{{ route('dash.interests.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-icons"></i>
                    </div>
                    <span class="nav-link-text ms-1">@lang('main.interests')</span>
                </a>
            </li>
            @endcan
            @can('browse user')
            <li class="nav-item">
                <a @class(['nav-link', 'active'=> request()->routeIs('dash.users*')])
                    href="{{ route('dash.users.index') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-icons"></i>
                    </div>
                    <span class="nav-link-text ms-1">@lang('main.users')</span>
                </a>
            </li>
            @endcan
            <li class="nav-item">
                <hr class="horizontal dark" />
            </li>
            @canany(['browse role', 'browse admin', 'browse country'])
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#managementNavMenu" aria-controls="managementNavMenu"
                    @class(['nav-link', 'active'=> request()->is(['dashboard/roles*','dashboard/admins*'])])
                    role="button" aria-expanded="false">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-people-roof"></i>
                    </div>
                    <span class="nav-link-text ms-1">@lang('main.management')</span>
                </a>
                <div @class(['collapse', 'show'=>
                    request()->is(['dashboard/roles*','dashboard/admins*','dashboard/countries*','dashboard/cities*'])])
                    id="managementNavMenu">
                    <ul class="nav ms-4 ps-3">
                        @can('browse role')
                        <li class="nav-item ">
                            <a @class(['nav-link', 'active'=> request()->routeIs('dash.roles*')])
                                href="{{ route('dash.roles.index') }}">
                                <span class="sidenav-mini-icon"> @lang('main.roles') </span>
                                <span class="sidenav-normal"> @lang('main.roles') </span>
                            </a>
                        </li>
                        @endcan
                        @can('browse admin')
                        <li class="nav-item ">
                            <a @class(['nav-link', 'active'=> request()->routeIs('dash.admins*')])
                                href="{{ route('dash.admins.index') }}">
                                <span class="sidenav-mini-icon"> @lang('main.admins') </span>
                                <span class="sidenav-normal"> @lang('main.admins') </span>
                            </a>
                        </li>
                        @endcan
                        @can('browse country')
                        <li class="nav-item">
                            <a @class(['nav-link', 'active'=> request()->routeIs('dash.countries*')])
                                href="{{ route('dash.countries.index') }}">
                                <span class="sidenav-mini-icon"> @lang('main.countries') </span>
                                <span class="sidenav-normal"> @lang('main.countries') </span>
                            </a>
                        </li>
                        @endcan
                        @can('browse city')
                        <li class="nav-item">
                            <a @class(['nav-link', 'active'=> request()->routeIs('dash.cities*')])
                                href="{{ route('dash.cities.index') }}">
                                <span class="sidenav-mini-icon"> @lang('main.cities') </span>
                                <span class="sidenav-normal"> @lang('main.cities') </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcanany
        </ul>
    </div>
</aside>