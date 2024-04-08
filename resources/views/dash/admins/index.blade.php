@extends('dash.layouts.master')
@section('title', __('main.admins'))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-lg-flex justify-content-between align-items-center">
                    <h5 class="mb-0">@lang('main.admins')</h5>
                    @can('add admin')
                    <a href="{{ route('dash.admins.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp;
                        @lang('main.create.admin')</a>
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
                                <th>@lang('main.email')</th>
                                <th>@lang('main.created_at')</th>
                                <th data-sortable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $key => $admin)
                            <tr>
                                <td class="text-sm">{{ $admins->firstItem() + $key }}</td>
                                <td>
                                    <h6 class="ms-3 my-auto">{{ $admin->name }}</h6>
                                </td>
                                <td class="text-sm">{{ $admin->email }}</td>
                                <td class="text-sm">{{ $admin->created_at->toDateString() }}</td>
                                <td class="text-sm">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        @can('edit admin')
                                        <a href="{{ route('dash.admins.edit', $admin->id) }}" class="mx-3"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="@lang('main.update.product')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @endcan
                                        @if ($admin->id != 1)
                                        @can('delete admin')
                                        @include('dash.components.delete-model', ['route' => 'dash.admins.destroy', 'id'
                                        => $admin->id])
                                        @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($admins->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $admins->appends(['q' => request('q')])->links() }}
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