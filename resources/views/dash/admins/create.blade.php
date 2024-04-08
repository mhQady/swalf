@extends('dash.layouts.master',['breads' => [['title' => __('main.admins'), 'url' => route('dash.admins.index')]]])
@section('title', __('main.create.admin'))
@section('content')
<form action="{{ route('dash.admins.store') }}" method="post">
    <div class="d-flex justify-content-between align-items-center">
        <h4>@lang('main.create.admin')</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @include('dash.admins._form',['admin' => null])
</form>
@endSection