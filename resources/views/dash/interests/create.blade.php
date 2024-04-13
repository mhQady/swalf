@extends('dash.layouts.master',['breads' => [['title' => __('main.interests'), 'url' =>
route('dash.interests.index')]]])
@section('title', __('main.create.interest'))
@section('content')
<form action="{{ route('dash.interests.store') }}" method="POST" enctype="multipart/form-data">
    <div class="d-flex justify-content-between align-items-center">
        <h4>@lang('main.create.interest')</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @include('dash.interests._form',['interest' => null])
</form>
@endSection