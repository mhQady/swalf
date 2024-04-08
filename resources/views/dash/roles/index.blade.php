@extends('dash.layouts.master')
@section('title', __('main.roles'))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-lg-flex justify-content-between align-items-center">
                    <h5 class="mb-0">@lang('main.roles')</h5>
                    @can('add role')
                    <a href="{{ route('dash.roles.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp;
                        @lang('main.create.role')</a>
                    @endcan
                </div>
            </div>
            <div class="card-body px-0 pb-0">
                <div class="table-responsive">
                    <table class="table table-flush rtl" id="items-list">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>@lang('main.name')</th>
                                <th>@lang('main.created_at')</th>
                                <th data-sortable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                                <td class="text-sm">{{ $roles->firstItem() + $key }}</td>
                                <td>
                                    <h6 class="ms-3 my-auto">{{ $role->name }}</h6>
                                </td>
                                <td class="text-sm">{{ $role->created_at->toDateString() }}</td>
                                <td class="text-sm">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        @can('edit role')
                                        <a href="{{ route('dash.roles.edit', $role->id) }}" class="mx-3"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="@lang('main.update.product')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @endcan
                                        @if ($role->id != 1)
                                        @can('delete role')
                                        @include('dash.components.delete-model', ['route' => 'dash.roles.destroy', 'id'
                                        => $role->id])
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
            <div class="card-footer">
                {{ $roles->links() }}
            </div>
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