@extends('dash.layouts.master',['breads' => [['title' => __('main.countries'), 'url' =>
route('dash.countries.index')]]])
@section('title', __('main.create.country'))
@section('content')
<form action="{{ route('dash.countries.store') }}" method="POST">
    <div class="d-flex justify-content-between align-items-center">
        <h4>@lang('main.create.country')</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @include('dash.countries._form',['country' => null])
</form>
@endSection