@extends('dash.layouts.master',['breads' => [['title' => __('main.roles'), 'url' => route('dash.roles.index')]]])
@section('title', $role->name)
@section('content')
<form action="{{ route('dash.roles.update', $role->id) }}" method="POST">
    <div class="d-flex justify-content-between align-items-center">
        <h4>{{ $role->name }}</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @method('PATCH')
    @include('dash.roles._form', ['role' => $role])
</form>
@endSection