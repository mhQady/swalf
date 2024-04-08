<div class="row mt-4">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label>@lang('main.name')</label>
                            <input class="form-control" type="text" name="name"
                                value="{{ old('name', $role?->name) }}" />
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            @error('permissions') <small class="text-danger">{{ $message }}</small> @enderror
                            @error('permissions.*') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-check d-flex justify-content-between align-items-center">
                            <label class="custom-control-label mb-0" for="selectAll">
                                <h6 class="mb-0">@lang("main.select.all")</h6>
                            </label>
                            <input class="form-check-input" type="checkbox" id="selectAll">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
    $oldPermissions = old('permissions', $role?->permissions->pluck('id')->toArray() ?? []);
    @endphp
    @foreach ($permissions as $key => $permission)
    <div class="col-3 mt-4">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-check d-flex justify-content-between align-items-center">
                    <label class="custom-control-label mb-0" for="{{ $key.'Check' }}">
                        <h6 class="mb-0">@lang("main.".str()->plural($key))</h6>
                    </label>
                    <input class="form-check-input selectModel" type="checkbox" value="{{ $key }}"
                        id="{{ $key.'Check' }}">
                </div>
                <hr class="horizontal dark my-2">
                <ul>
                    @foreach ($permission as $item)
                    <li>
                        <div class="form-check">
                            <label class="custom-control-label" for="{{ $item->name.'Check' }}">
                                @lang("permissions.".str_replace(" ",".", $item->name))
                            </label>
                            <input class="form-check-input {{ $key.'Model' }}" type="checkbox" value="{{ $item->id }}"
                                id="{{ $item->name.'Check' }}" name="permissions[]"
                                @checked(in_array($item->id,$oldPermissions))>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endforeach
</div>
@push('scripts')
<script type="text/javascript">
    document.querySelectorAll('.selectModel').forEach(function(el) {
        el.addEventListener('change', function(e) {

            let subs = document.querySelectorAll('.'+e.target.value+'Model');

            if(e.target.checked) {
                subs.forEach((element) => element.checked = true)
            } else {
                subs.forEach((element) =>element.checked = false)
            }
        })
    })

    let allSubs = document.querySelectorAll('.form-check-input');
    document.querySelector('#selectAll').addEventListener('change', function(e) {
        if(e.target.checked) {
        allSubs.forEach((element) => element.checked = true)
        } else {
        allSubs.forEach((element) =>element.checked = false)
        }
    })
</script>
@endpush