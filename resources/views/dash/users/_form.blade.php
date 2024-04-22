@php
use \App\Enums\Country\StatusEnum;
use \App\Enums\Country\HasMarketEnum;
@endphp

@csrf
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>@lang('main.name')</label>
                            <input class="form-control" type="text" name="name"
                                value="{{ old('name', $country?->name) }}" />
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>@lang('main.code')</label>
                            <input class="form-control" type="text" name="code"
                                value="{{ old('code', $country?->code) }}" />
                            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>@lang('main.phone_code')</label>
                            <input class="form-control" type="text" name="phone_code"
                                value="{{ old('phone_code', $country?->phone_code) }}" />
                            @error('phone_code') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>@lang('main.currency')</label>
                            <input class="form-control" type="text" name="currency_code"
                                value="{{ old('currency_code', $country?->currency_code) }}" />
                            @error('currency_code') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>@lang('main.status')</label>
                            <select name="is_active" class="form-control">
                                @foreach (StatusEnum::mapForSelect() as $role)
                                <option value="{{ $role['value'] }}" @selected(old('is_active', $country?->is_active) ==
                                    $role['value'])>
                                    {{ $role['label'] }}
                                </option>
                                @endforeach
                            </select>
                            @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>@lang('main.has_market')</label>
                            <select name="has_market" class="form-control">
                                @foreach (HasMarketEnum::mapForSelect() as $role)
                                <option value="{{ $role['value'] }}" @selected(old('has_market', $country?->has_market)
                                    ==
                                    $role['value'])>
                                    {{ $role['label'] }}
                                </option>
                                @endforeach
                            </select>
                            @error('has_market') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>