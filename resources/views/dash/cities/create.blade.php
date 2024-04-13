@extends('dash.layouts.master',['breads' => [['title' => __('main.cities'), 'url' => route('dash.cities.index')]]])
@section('title', __('main.create.city'))
@section('content')
<form action="{{ route('dash.cities.store') }}" method="POST">
    <div class="d-flex justify-content-between align-items-center">
        <h4>@lang('main.create.city')</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @include('dash.cities._form',['city' => null])
</form>
@endSection