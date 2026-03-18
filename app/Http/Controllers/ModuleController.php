<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        if (\Auth::user()->type == 'super admin') {
            $modules = Module::withCount('permissions')->get();
            return view('module.index', compact('modules'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->type == 'super admin') {
            $request->validate([
                'name' => 'required|unique:modules,name',
            ]);

            Module::create([
                'name' => strtolower($request->name),
            ]);

            return redirect()->back()->with('success', __('Module created successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->type == 'super admin') {
            $module = Module::findOrFail($id);
            
            // Unlink permissions before deleting
            $module->permissions()->update(['module_id' => null]);
            
            $module->delete();

            return redirect()->back()->with('success', __('Module deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
