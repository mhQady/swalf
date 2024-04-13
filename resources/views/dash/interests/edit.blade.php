@extends('dash.layouts.master',['breads' => [['title' => __('main.interests'), 'url' =>
route('dash.interests.index')]]])
@section('title', $interest->name)
@section('content')
<form action="{{ route('dash.interests.update', $interest->id) }}" method="POST" enctype="multipart/form-data">
    <div class="d-flex justify-content-between align-items-center">
        <h4>{{ $interest->name }}</h4>
        <button type="submit" class="btn bg-gradient-primary mb-0">@lang('main.save')</button>
    </div>
    @method('PATCH')
    @include('dash.interests._form', ['interest' => $interest])
</form>
@endSection