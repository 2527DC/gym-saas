<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Get Settings Module
        $module = \App\Models\Module::where('name', 'settings')->first();
        
        if (!$module) {
            $module = \App\Models\Module::create(['name' => 'settings']);
        }

        // 2. Create Permissions under Settings
        $permissions = [
            'manage sms settings',
        ];

        foreach ($permissions as $permissionName) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
                'module_id' => $module->id,
            ]);
        }

        // 3. Keep other permissions for Trainee/Communication if needed, 
        // but user specifically asked for "sms reminder notification inside setting module"
        // Let's also move reminder logs and manual reminder to appropriate modules if they exist.
        
        $traineeModule = \App\Models\Module::where('name', 'trainee')->first();
        if ($traineeModule) {
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => 'send manual reminder',
                'guard_name' => 'web',
                'module_id' => $traineeModule->id,
            ]);
            \Spatie\Permission\Models\Permission::firstOrCreate([
                'name' => 'view reminder logs',
                'guard_name' => 'web',
                'module_id' => $traineeModule->id,
            ]);
        }

        // 4. Cleanup communication module if it was created
        $oldModule = \App\Models\Module::where('name', 'communication')->first();
        if ($oldModule) {
            // Re-assign any stragglers? No, we just explicitly assigned them above.
            $oldModule->delete();
        }
    }

    public function down()
    {
        // No need to delete settings module, just the permissions we added
        \Spatie\Permission\Models\Permission::where('name', 'manage sms settings')->delete();
        \Spatie\Permission\Models\Permission::where('name', 'send manual reminder')->delete();
        \Spatie\Permission\Models\Permission::where('name', 'view reminder logs')->delete();
    }
};
