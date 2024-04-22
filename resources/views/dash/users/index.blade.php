{{-- @php
use \App\Enums\Country\StatusEnum;
use \App\Enums\Country\HasMarketEnum;
@endphp --}}
@extends('dash.layouts.master')
@section('title', __('main.users'))
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-lg-flex justify-content-between align-items-center">
                    <h5 class="mb-0">@lang('main.users')</h5>
                    {{-- @can('add user')
                    <a href="{{ route('dash.users.create') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp;
                    @lang('main.create.user')</a>
                    @endcan --}}
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
                                <th>@lang('main.phone')</th>
                                <th>@lang('main.email')</th>
                                <th>@lang('main.gender')</th>
                                <th>@lang('main.status')</th>
                                <th>@lang('main.market')</th>
                                <th data-sortable="false"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr>
                                <td class="text-sm">{{ $users->firstItem() + $key }}</td>
                                <td>
                                    <h6 class="ms-3 my-auto">{{ $user->name }}</h6>
                                </td>
                                <td class="text-sm">{{ $user->fullPhone }}</td>
                                <td class="text-sm">{{ $user->email }}</td>
                                <td class="text-sm">{!! $user->gender->badge() !!}</td>
                                <td class="text-sm">{!! $user->status->badge() !!}</td>
                                <td class="text-sm">{{ $user->market?->name }}</td>
                                <td class="text-sm">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        @can('edit user')
                                        @include('dash.users._change-status')
                                        @endcan
                                        @can('delete user')
                                        @include('dash.components.delete-model', ['route' => 'dash.users.destroy',
                                        'id'=> $user->id])
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($users->hasPages())
            <div class="card-footer d-flex justify-content-end">
                {{ $users->appends(['q' => request('q')])->links() }}
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