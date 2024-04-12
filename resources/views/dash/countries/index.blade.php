@php
use \App\Enums\Country\StatusEnum;
use \App\Enums\Country\HasMarketEnum;
@endphp
@extends('dash.layouts.master')
@section('title', __('main.countries'))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-lg-flex justify-content-between align-items-center">
                    <h5 class="mb-0">@lang('main.countries')</h5>
                    @can('add country')
                    <a href="{{ route('dash.countries.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp;
                        @lang('main.create.country')</a>
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
                                <th>@lang('main.code')</th>
                                <th>@lang('main.currency')</th>
                                <th>@lang('main.phone_code')</th>
                                <th>@lang('main.status')</th>
                                <th>@lang('main.has_market')</th>
                                <th data-sortable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($countries as $key => $country)
                            <tr>
                                <td class="text-sm">{{ $countries->firstItem() + $key }}</td>
                                <td>
                                    <h6 class="ms-3 my-auto">{{ $country->name }}</h6>
                                </td>
                                <td class="text-sm">{{ $country->code }}</td>
                                <td class="text-sm">{{ $country->currency_code }}</td>
                                <td class="text-sm">{{ $country->phone_code }}</td>
                                <td class="text-sm">{!! StatusEnum::badge($country->is_active->value) !!}</td>
                                <td class="text-sm">{!! HasMarketEnum::badge($country->has_market->value) !!}</td>
                                <td class="text-sm">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        @can('edit country')
                                        <a href="{{ route('dash.countries.edit', $country->id) }}" class="mx-3"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="@lang('main.update.product')">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @endcan
                                        @if ($country->id != 1)
                                        @can('delete country')
                                        @include('dash.components.delete-model', ['route' => 'dash.countries.destroy',
                                        'id'
                                        => $country->id])
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
            @if ($countries->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $countries->appends(['q' => request('q')])->links() }}
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