<a href="javascript:void(0)" class="mx-3" data-bs-toggle="modal" data-bs-target="#changeStatusModal-{{ $user->id }}">
    @if ($user->isBanned)
    <i class="fa-solid fa-rotate-left text-success"></i>
    @else
    <i class="fa-solid fa-ban text-danger"></i>
    @endif
</a>

<div class="modal fade" id="changeStatusModal-{{ $user->id }}" tabindex="-1" role="dialog"
    aria-labelledby="changeStatusModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h4>
                    @if ($user->isBanned)
                    @lang('messages.Are you sure you want to restore this user')
                    @else
                    @lang('messages.Are you sure you want to ban this user')
                    @endif
                </h4>
            </div>
            <div class="modal-footer">
                <form action="{{ route('dash.users.change-status', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="button" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">@lang('main.cancel')</button>

                    <button type="submit" @class(['btn text-white','bg-danger'=> !$user->isBanned,'bg-success'=>
                        $user->isBanned])>
                        @lang('main.confirm.0')
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>