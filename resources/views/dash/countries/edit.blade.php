@extends('dash.layouts.master',['breads' => [['title' => __('main.countries'), 'url' =>
route('dash.countries.index')]]])
@section('title', $country->name)
@section('content')
<form action="{{ route('dash.countries.update', $country->id) }}" method="POST">
    <div class="d-flex justify-content-between align-items-center">
        <h4>{{ $country->name }}</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @method('PATCH')
    @include('dash.countries._form', ['country' => $country])
</form>
@endSection