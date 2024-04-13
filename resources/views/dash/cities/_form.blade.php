@csrf
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>@lang('main.name')</label>
                            <input class="form-control" type="text" name="name"
                                value="{{ old('name', $city?->name) }}" />
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>@lang('main.country')</label>
                            <select name="country_id" class="form-control">
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @selected(old('country_id', $city?->
                                    state?->country_id)
                                    ==$country->id)>
                                    {{ $country->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('country_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>