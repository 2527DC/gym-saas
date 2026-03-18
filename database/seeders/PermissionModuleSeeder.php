<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionModuleSeeder extends Seeder
{
    public function run()
    {
        $modules = [
            'user', 'trainer', 'trainee', 'class', 'category', 'workout', 'membership',
            'health', 'attendance', 'invoice', 'expense', 'finance type', 'notification',
            'contact', 'note', 'logged history', 'settings', 'locker', 'event',
            'nutrition schedule', 'product', 'role', 'permission', 'pricing', 'coupon',
            'FAQ', 'Page', 'auth', 'home'
        ];

        foreach ($modules as $moduleName) {
            Module::firstOrCreate(['name' => $moduleName]);
        }

        $allModules = Module::all();
        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $assigned = false;
            // Iterate in reverse to match more specific modules first if needed
            // For example 'user assign class' should match 'user' or 'class'? 
            // In the original logic, it matched 'user' because 'user' came first in the array.
            foreach ($allModules as $module) {
                if (str_contains(strtolower($permission->name), strtolower($module->name))) {
                    $permission->module_id = $module->id;
                    $permission->save();
                    $assigned = true;
                    break;
                }
            }
        }
    }
}
