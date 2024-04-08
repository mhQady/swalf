@extends('dash.layouts.master',['breads' => [['title' => __('main.admins'), 'url' => route('dash.admins.index')]]])
@section('title', $admin->name)
@section('content')
<form action="{{ route('dash.admins.update', $admin->id) }}" method="POST">
    <div class="d-flex justify-content-between align-items-center">
        <h4>{{ $admin->name }}</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @method('PATCH')
    @include('dash.admins._form', ['admin' => $admin])
</form>
@endSection