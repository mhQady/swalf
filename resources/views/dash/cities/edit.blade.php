@extends('dash.layouts.master',['breads' => [['title' => __('main.cities'), 'url' =>
route('dash.cities.index')]]])
@section('title', $city->name)
@section('content')
<form action="{{ route('dash.cities.update', $city->id) }}" method="POST">
    <div class="d-flex justify-content-between align-items-center">
        <h4>{{ $city->name }}</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @method('PATCH')
    @include('dash.cities._form', ['city' => $city])
</form>
@endSection