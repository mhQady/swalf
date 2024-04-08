<form method="GET">
    <div class="row justify-content-end">
        <div class="col-3">
            <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input name="q" value="{{ request('q') }}" type="text" class="form-control"
                    placeholder="@lang('main.type_here')" spellcheck="true" data-ms-editor="true">
            </div>
        </div>
    </div>
</form>