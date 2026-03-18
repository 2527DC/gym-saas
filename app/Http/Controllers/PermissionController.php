<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{

    public function index()
    {
        $permissionData = Permission::orderBy('id', 'desc')->get();
        return view('user_permission.index', compact('permissionData'));
    }



    public function create()
    {
        $userRoles = Role::get()->pluck('name', 'id');
        $modules = \App\Models\Module::get()->pluck('name', 'id');
        return view('user_permission.create', compact('userRoles', 'modules'));
    }


    public function store(Request $request)
    {

        $validator = \Validator::make(
            $request->all(),
            [
                'title' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $moduleId = $request->module_id;
        if (!empty($request->new_module)) {
            $module = \App\Models\Module::firstOrCreate(['name' => strtolower($request->new_module)]);
            $moduleId = $module->id;
        }

        $permissions = explode(',', $request->title);
        foreach ($permissions as $permission) {
            $userPermission = new Permission();
            $userPermission->name = $permission;
            $userPermission->module_id = $moduleId;
            $userPermission->save();
            if (!empty($request->user_roles)) {
                foreach ($request->user_roles as $userRole) {
                    $role = Role::find($userRole);
                    $role->givePermissionTo($userPermission);
                }
            }
        }
        return redirect()->back()->with('success', 'Permission successfully created.');
    }


    public function destroy($id)
    {
        $permission = Permission::find(decrypt($id));
        $permission->delete();
        return redirect()->back()->with('success', 'Permission successfully deleted.');
    }
}
