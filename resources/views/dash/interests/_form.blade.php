@csrf
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>@lang('main.name')</label>
                            <input class="form-control" type="text" name="name[ar]" value="{{ old('name
                                ar', $interest?->name) }}" />
                            @error('name.ar') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>