@extends('dash.layouts.master')
@section('title', __('main.cities'))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-lg-flex justify-content-between align-items-center">
                    <h5 class="mb-0">@lang('main.cities')</h5>
                    @can('add city')
                    <a href="{{ route('dash.cities.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp;
                        @lang('main.create.city')</a>
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
                                <th>@lang('main.country')</th>
                                <th data-sortable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cities as $key => $city)
                            <tr>
                                <td class="text-sm">{{ $cities->firstItem() + $key }}</td>
                                <td>
                                    <h6 class="ms-3 my-auto">{{ $city->name }}</h6>
                                </td>
                                <td>{{ $city->country?->name }}</td>
                                <td class="text-sm">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        @can('edit city')
                                        <a href="{{ route('dash.cities.edit', $city->id) }}" class="mx-3"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="@lang('main.update.product')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @endcan
                                        @can('delete city')
                                        @include('dash.components.delete-model', ['route' => 'dash.cities.destroy', 'id'
                                        => $city->id])
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($cities->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $cities->appends(['q' => request('q')])->links() }}
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