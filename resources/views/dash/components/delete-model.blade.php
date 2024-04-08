<a href="javascript:void(0)" class="mx-3" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $id }}">
    <i class="fa-solid fa-trash text-danger"></i>
</a>

<div class="modal fade" id="deleteModal-{{ $id }}" tabindex="-1" role="dialog"
    aria-labelledby="deleteModalLabel-{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4>
                    @lang('main.sure.delete')
                </h4>
            </div>
            <div class="modal-footer">
                <form action="{{ route($route, $id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">@lang('main.cancel')</button>
                    <button type="submit" class="btn bg-danger text-white">@lang('main.confirm.0')</button>
                </form>
            </div>
        </div>
    </div>
</div>