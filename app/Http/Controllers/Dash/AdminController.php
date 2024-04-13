<?php

namespace App\Http\Controllers\Dash;

use App\Models\Role;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dash\AdminRequest;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('browse admin');

        $admins = Admin::notSuperAdmin()->filter()->latest()->paginate(columns: ['id', 'name', 'email', 'created_at']);

        return view('dash.admins.index', compact('admins'));
    }

    public function create()
    {
        $this->authorize('add admin');

        $roles = Role::latest()->get(['id', 'name']);

        return view('dash.admins.create', compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->only(['name', 'email', 'password']));

        $admin->roles()->sync($request->roles);

        toast(__('main.created.admin'), 'success');

        return to_route('dash.admins.index');
    }

    public function edit(Admin $admin)
    {
        $this->authorize('edit admin');

        $admin->load('roles:id,name');

        $roles = Role::latest()->get(['id', 'name']);

        return view('dash.admins.edit', compact('roles', 'admin'));
    }

    public function update(Admin $admin, AdminRequest $request)
    {
        $data = $request->password ? ['name', 'email', 'password'] : ['name', 'email'];

        $admin->update($request->only($data));

        $admin->roles()->sync($request->roles);

        toast(__('main.updated.admin'), 'success');

        return to_route('dash.admins.index');
    }

    public function destroy(Admin $admin)
    {
        $this->authorize('delete admin');

        if ($admin->id == 1 || $admin->name == 'Super Admin') {
            toast(__('messages.You can not delete Super Admin Account'), 'warning');
            return back();
        }

        $admin->delete();

        toast(__('main.deleted.admin'), 'success');

        return to_route('dash.admins.index');
    }
}
