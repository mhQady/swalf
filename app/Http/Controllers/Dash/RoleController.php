<?php

namespace App\Http\Controllers\Dash;

use App\Models\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dash\RoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('browse role');

        $roles = Role::filter()->latest()->paginate(columns: ['id', 'name', 'created_at']);

        return view('dash.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('add role');

        $permissions = Permission::get(['id', 'name', 'model'])->groupBy('model');

        return view('dash.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request->validated()['name'], 'guard_name' => 'admin']);

        $role->permissions()->sync($request->validated()['permissions']);

        toast(__('main.created.role'), 'success');

        return to_route('dash.roles.index');
    }

    public function edit(Role $role)
    {
        $this->authorize('edit role');

        $role->load('permissions:id,name');

        $permissions = Permission::get(['id', 'name', 'model'])->groupBy('model');

        return view('dash.roles.edit', compact('permissions', 'role'));
    }

    public function update(Role $role, RoleRequest $request)
    {
        $role->update(['name' => $request->validated()['name']]);

        $role->permissions()->sync($request->validated()['permissions']);

        toast(__('main.updated.role'), 'success');

        return to_route('dash.roles.index');
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete role');

        if ($role->id == 1 || $role->name == 'super-admin') {
            toast(__('messages.You can not delete Super Admin Role'), 'warning');
            return back();
        }

        $role->delete();

        toast(__('main.deleted.role'), 'success');

        return to_route('dash.roles.index');
    }
}
