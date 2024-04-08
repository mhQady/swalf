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
                                value="{{ old('name', $admin?->name) }}" />
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>@lang('main.email')</label>
                            <input class="form-control" type="email" name="email"
                                value="{{ old('email', $admin?->email) }}" />
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>@lang('main.password')</label>
                            <input class="form-control" type="password" name="password" />
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>@lang('main.confirm_password')</label>
                            <input class="form-control" type="text" name="password_confirmation" />
                            @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label>@lang('main.roles')</label>
                            <select name="roles[]" id="rolesSelector" multiple>
                                <option value="">&nbsp;</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}" @selected(in_array($role->id, old('roles',
                                    $admin?->roles->pluck('id')->toArray() ?? [])))>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('roles') <small class="text-danger">{{ $message }}</small> @enderror
                            @error('roles.*') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    window.onload = function() {
        new Choices(document.getElementById('rolesSelector'), {
            removeItemButton: true
        });
}
</script>

@endpush