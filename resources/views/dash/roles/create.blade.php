@extends('dash.layouts.master',['breads' => [['title' => __('main.roles'), 'url' => route('dash.roles.index')]]])
@section('title', __('main.create.role'))
@section('content')
<form action="{{ route('dash.roles.store') }}" method="POST">
    <div class="d-flex justify-content-between align-items-center">
        <h4>@lang('main.create.role')</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @include('dash.roles._form',['role' => null])
</form>
@endSection