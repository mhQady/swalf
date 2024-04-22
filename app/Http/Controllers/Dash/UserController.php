<?php

namespace App\Http\Controllers\Dash;

use App\Enums\User\StatusEnum;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('browse user');

        $users = User::filter()->latest()->with('market')
            ->paginate(columns: ['id', 'name', 'email', 'gender', 'phone_code', 'phone', 'birth_date', 'country_id', 'created_at', 'status']);

        return view('dash.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete user');

        $user->delete();

        toast(__('main.deleted.user'), 'success');

        return to_route('dash.users.index');
    }

    public function changeStatus(User $user)
    {

        $data = match ($user->status) {
            StatusEnum::BANNED => ['status' => StatusEnum::ACTIVE->value, 'message' => __('main.restored.user')],
            StatusEnum::ACTIVE => ['status' => StatusEnum::BANNED->value, 'message' => __('main.banned.user')],
        };

        $user->update(['status' => $data['status']]);

        toast($data['message'], 'success');

        return to_route('dash.users.index');
    }
}
