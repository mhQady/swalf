@extends('dash.layouts.master')
@section('title', __('main.interests'))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-lg-flex justify-content-between align-items-center">
                    <h5 class="mb-0">@lang('main.interests')</h5>
                    @can('add interest')
                    <a href="{{ route('dash.interests.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp;
                        @lang('main.create.interest')</a>
                    @endcan
                </div>
            </div>
            <div class="card-header pb-0">
                @include('dash.components.search')
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-flush rtl" id="items-list">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>@lang('main.name')</th>
                                <th>@lang('main.count.product')</th>
                                <th>@lang('main.created_at')</th>
                                <th data-sortable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($interests as $key => $interest)
                            <tr>
                                <td class="text-sm">{{ $interests->firstItem() + $key }}</td>
                                <td>
                                    <h6 class="ms-3 my-auto">{{ $interest->name }}</h6>
                                </td>
                                <td class="text-sm">{{ $interest->products_count }}</td>
                                <td class="text-sm">{{ $interest->created_at->toDateString() }}</td>
                                <td class="text-sm">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        @can('edit interest')
                                        <a href="{{ route('dash.interests.edit', $interest->id) }}" class="mx-3"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="@lang('main.update.product')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @endcan
                                        @can('delete interest')
                                        @include('dash.components.delete-model', ['route' => 'dash.interests.destroy',
                                        'id'
                                        => $interest->id])
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($interests->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $interests->appends(['q' => request('q')])->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endSection
@push('scripts')
<script type="text/javascript">
    window.onload = function() {
    new simpleDatatables.DataTable("#items-list", {
    searchable: false,
    fixedHeight: false,
    paging: false
    });

}
</script>
@endpush