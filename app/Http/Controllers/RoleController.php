<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Module;


class RoleController extends Controller
{

    public function index()
    {
         $roleData = Role::where('parent_id', parentId())->orderBy('id', 'desc')->get();
            return view('role.index', compact('roleData'));
    }


    public function create()
    {
        if (\Auth::user()->type == 'super admin') {
            $modules = Module::with('permissions')->get();
        } else {
            $modules = Module::with(['permissions' => function ($query) {
                // This is slightly complex to do in one query without a custom relationship
                // So we'll fetch everything and filter in the view or here.
            }])->get();
            
            // Revert to old behavior for non-superadmin for now or just fetch modules.
            $permissionList = new Collection();
            foreach (\Auth::user()->roles as $role) {
                $permissionList = $permissionList->merge($role->permissions);
            }
            // Group the permissionList by module_id if we want to be consistent
        }
        
        // Actually, to keep it simple and consistent for both:
        $modules = Module::with('permissions')->get();
        // We will handle the "available permissions" filter in the view 
        // by checking if the permission is in the $permissionList or if user is super admin.

        return view('role.create', compact('modules'));
    }


    public function store(Request $request)
    {

       $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required|unique:roles,name,null,id,parent_id,' . parentId(),
                    'user_permission' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route('role.index')->with('error', $messages->first());
            }

            $userRole = new Role();
            $userRole->name = $request->title;
            $userRole->parent_id = parentId();
            $userRole->save();
            foreach ($request->user_permission as $permission) {
                $result = Permission::find($permission);
                $userRole->givePermissionTo($result);
            }
            return redirect()->route('role.index')->with('success', __('Role successfully created.'));

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $role = Role::find($id);
        $modules = Module::with('permissions')->get();

        $assignPermission = $role->permissions;
        $assignPermission = $assignPermission->pluck('id')->toArray();

        return view('role.edit', compact('role', 'modules', 'assignPermission'));
    }


    public function update(Request $request, $id)
    {
       $userRole = Role::find($id);
            $validator = \Validator::make(
                $request->all(), [
                    'title' => 'required|unique:roles,name,' . $userRole->id . ',id,parent_id,' . parentId(),
                    'user_permission' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route('role.index')->with('error', $messages->first());
            }
            $permissionData = $request->except(['permissions']);
            $assignPermissions = $request->user_permission;
            $userRole->fill($permissionData)->save();

            $permissionList = Permission::all();
            foreach ($permissionList as $revokePermission) {
                $userRole->revokePermissionTo($revokePermission);
            }
            foreach ($assignPermissions as $assignPermission) {
                $assign = Permission::find($assignPermission);
                $userRole->givePermissionTo($assign);
            }
            return redirect()->route('role.index')->with('success', __('Role successfully updated.'));

    }


    public function destroy($id)
    {
       $userRole = Role::find(decrypt($id));
            $userRole->delete();
            return redirect()->route('role.index')->with('success', 'Role successfully deleted.');
    }

}
