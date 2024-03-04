@extends('dash.layouts.auth')
@section('title', __('main.login'))
@section('content')
<section>
    <div class="page-header min-vh-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                    <div class="card card-plain">
                        <div @class(["card-header pb-0", "text-start"=> app()->getLocale() == 'en', "text-end"=>
                            app()->getLocale() == 'ar'])>
                            <h4 class="font-weight-bolder">@lang('main.login')</h4>
                        </div>
                        <div class="card-body">
                            <form role="form" method="POST" action="{{ route('dash.authenticate') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg"
                                        placeholder="@lang('main.email')" aria-label="Email" name="email"
                                        value="{{ old('email') }}">
                                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg"
                                        placeholder="@lang('main.password')" aria-label="Password" name="password">
                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-check form-switch" dir="ltr">
                                    <input class="form-check-input" @checked(old('remember')) type="checkbox"
                                        id="rememberMe" name="remember" value="1">
                                    <label class="form-check-label" for="rememberMe">@lang('main.remember_me')</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit"
                                        class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">@lang('main.login')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div @class(["col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute text-center
                    justify-content-center flex-column top-0", "end-0"=> app()->getLocale() == 'en', "start-0"=>
                    app()->getLocale() == 'ar'])>
                    <div
                        class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
                        <img src="{{ Vite::img('shapes/pattern-lines.svg') }}" alt="pattern-lines"
                            @class(['position-absolute opacity-4', 'start-0'=> app()->getLocale() == 'en', 'end-0'=>
                        app()->getLocale() == 'ar'])>
                        <div class="position-relative">
                            <img class="max-width-500 w-100 position-relative z-index-2"
                                src="{{ Vite::img('illustrations/chat.png') }}" alt="chat-img">
                        </div>
                        <h4 class="mt-5 text-white font-weight-bolder">{{ config('app.name') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection