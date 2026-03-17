<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;

class DefaultDataUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default All Permission
        $currentRouteName = Route::currentRouteName();
        if ($currentRouteName != 'LaravelUpdater::database') {

            $allPermission = [
                [
                    'name' => 'manage user',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create user',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit user',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete user',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show user',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage role',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create role',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit role',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete role',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage contact',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create contact',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit contact',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete contact',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage note',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create note',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit note',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete note',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage logged history',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete logged history',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage pricing packages',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create pricing packages',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit pricing packages',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete pricing packages',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'buy pricing packages',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage pricing transation',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage coupon',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create coupon',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit coupon',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete coupon',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage coupon history',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete coupon history',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage account settings',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage password settings',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage general settings',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage company settings',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage email settings',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage payment settings',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage seo settings',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage google recaptcha settings',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage notification',
                    'gaurd_name' => 'web',
                ],
                [
                    'gaurd_name' => 'web',
                    'name' => 'edit notification',
                ],
                [
                    'name' => 'manage FAQ',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create FAQ',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit FAQ',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete FAQ',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage Page',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create Page',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit Page',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete Page',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show Page',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage home page',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit home page',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage footer',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit footer',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage 2FA settings',
                    'guard_name' => 'web',
                ],

                [
                    'name' => 'manage trainer',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create trainer',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit trainer',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete trainer',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show trainer',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage trainee',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create trainee',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit trainee',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete trainee',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show trainee',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage class',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create class',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit class',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete class',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show class',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'assign user class',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete user class',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage category',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create category',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit category',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete category',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage workout activity',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create workout activity',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit workout activity',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete workout activity',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage membership',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create membership',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit membership',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete membership',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show membership',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage workout',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create workout',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit workout',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete workout',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show workout',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage today workout',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage health update',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create health update',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit health update',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete health update',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show health update',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage attendance',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create attendance',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit attendance',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete attendance',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage today attendance',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage invoice',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create invoice',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit invoice',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete invoice',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show invoice',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete invoice type',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create invoice payment',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete invoice payment',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage expense',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create expense',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit expense',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete expense',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'show expense',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage finance type',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'create finance type',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'edit finance type',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'delete finance type',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'user assign class',
                    'guard_name' => 'web',
                ],
                [
                    'name' => 'manage auth page',
                    'guard_name' => 'web',
                ],

            ];
            Permission::insert($allPermission);

            // Default Super Admin Role
            $superAdminRoleData =  [
                'name' => 'super admin',
                'parent_id' => 0,
            ];
            $systemSuperAdminRole = Role::create($superAdminRoleData);
            $systemSuperAdminPermission = [
                ['name' => 'manage user'],
                ['name' => 'create user'],
                ['name' => 'edit user'],
                ['name' => 'delete user'],
                ['name' => 'show user'],
                ['name' => 'manage contact'],
                ['name' => 'create contact'],
                ['name' => 'edit contact'],
                ['name' => 'delete contact'],
                ['name' => 'manage note'],
                ['name' => 'create note'],
                ['name' => 'edit note'],
                ['name' => 'delete note'],
                ['name' => 'manage pricing packages'],
                ['name' => 'create pricing packages'],
                ['name' => 'edit pricing packages'],
                ['name' => 'delete pricing packages'],
                ['name' => 'manage pricing transation'],
                ['name' => 'manage coupon'],
                ['name' => 'create coupon'],
                ['name' => 'edit coupon'],
                ['name' => 'delete coupon'],
                ['name' => 'manage coupon history'],
                ['name' => 'delete coupon history'],
                ['name' => 'manage account settings'],
                ['name' => 'manage password settings'],
                ['name' => 'manage general settings'],
                ['name' => 'manage email settings'],
                ['name' => 'manage payment settings'],
                ['name' => 'manage seo settings'],
                ['name' => 'manage google recaptcha settings'],
                ['name' => 'manage FAQ'],
                ['name' => 'create FAQ'],
                ['name' => 'edit FAQ'],
                ['name' => 'delete FAQ'],
                ['name' => 'manage Page'],
                ['name' => 'create Page'],
                ['name' => 'edit Page'],
                ['name' => 'delete Page'],
                ['name' => 'show Page'],
                ['name' => 'manage home page'],
                ['name' => 'edit home page'],
                ['name' => 'manage footer'],
                ['name' => 'edit footer'],
                ['name' => 'manage 2FA settings'],
                ['name' => 'manage auth page'],

            ];
            $systemSuperAdminRole->givePermissionTo($systemSuperAdminPermission);
            // Default Super Admin
            $superAdminData =     [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'super admin',
                'lang' => 'english',
                'email_verified_at' => now(),
                'profile' => 'avatar.png',
            ];
            $systemSuperAdmin = User::create($superAdminData);
            $systemSuperAdmin->assignRole($systemSuperAdminRole);
            HomePageSection();
            CustomPage();
            authPage($systemSuperAdmin->id);
            DefaultBankTransferPayment();

            // Default Owner Role
            $ownerRoleData = [
                'name' => 'owner',
                'parent_id' => $systemSuperAdmin->id,
            ];
            $systemOwnerRole = Role::create($ownerRoleData);

            // Default Owner All Permissions
            $systemOwnerPermission = [
                ['name' => 'manage user'],
                ['name' => 'create user'],
                ['name' => 'edit user'],
                ['name' => 'delete user'],
                ['name' => 'manage role'],
                ['name' => 'create role'],
                ['name' => 'edit role'],
                ['name' => 'delete role'],
                ['name' => 'manage contact'],
                ['name' => 'create contact'],
                ['name' => 'edit contact'],
                ['name' => 'delete contact'],
                ['name' => 'manage note'],
                ['name' => 'create note'],
                ['name' => 'edit note'],
                ['name' => 'delete note'],
                ['name' => 'manage logged history'],
                ['name' => 'delete logged history'],
                ['name' => 'manage pricing packages'],
                ['name' => 'buy pricing packages'],
                ['name' => 'manage pricing transation'],
                ['name' => 'manage account settings'],
                ['name' => 'manage password settings'],
                ['name' => 'manage general settings'],
                ['name' => 'manage company settings'],
                ['name' => 'manage email settings'],
                ['name' => 'manage notification'],
                ['name' => 'edit notification'],
                ['name' => 'manage 2FA settings'],

                ['name' => 'manage trainer'],
                ['name' => 'create trainer'],
                ['name' => 'edit trainer'],
                ['name' => 'show trainer'],
                ['name' => 'delete trainer'],
                ['name' => 'manage trainee'],
                ['name' => 'create trainee'],
                ['name' => 'edit trainee'],
                ['name' => 'delete trainee'],
                ['name' => 'show trainee'],
                ['name' => 'manage class'],
                ['name' => 'create class'],
                ['name' => 'edit class'],
                ['name' => 'delete class'],
                ['name' => 'show class'],
                ['name' => 'assign user class'],
                ['name' => 'delete user class'],
                ['name' => 'manage category'],
                ['name' => 'create category'],
                ['name' => 'edit category'],
                ['name' => 'delete category'],
                ['name' => 'manage workout activity'],
                ['name' => 'create workout activity'],
                ['name' => 'edit workout activity'],
                ['name' => 'delete workout activity'],
                ['name' => 'manage membership'],
                ['name' => 'create membership'],
                ['name' => 'edit membership'],
                ['name' => 'delete membership'],
                ['name' => 'show membership'],
                ['name' => 'manage workout'],
                ['name' => 'create workout'],
                ['name' => 'edit workout'],
                ['name' => 'delete workout'],
                ['name' => 'show workout'],
                ['name' => 'manage today workout'],
                ['name' => 'manage health update'],
                ['name' => 'create health update'],
                ['name' => 'edit health update'],
                ['name' => 'delete health update'],
                ['name' => 'show health update'],
                ['name' => 'manage attendance'],
                ['name' => 'create attendance'],
                ['name' => 'edit attendance'],
                ['name' => 'delete attendance'],
                ['name' => 'manage today attendance'],
                ['name' => 'manage invoice'],
                ['name' => 'create invoice'],
                ['name' => 'edit invoice'],
                ['name' => 'delete invoice'],
                ['name' => 'show invoice'],
                ['name' => 'delete invoice type'],
                ['name' => 'create invoice payment'],
                ['name' => 'delete invoice payment'],
                ['name' => 'manage expense'],
                ['name' => 'create expense'],
                ['name' => 'edit expense'],
                ['name' => 'delete expense'],
                ['name' => 'show expense'],
                ['name' => 'manage finance type'],
                ['name' => 'create finance type'],
                ['name' => 'edit finance type'],
                ['name' => 'delete finance type'],
                ['name' => 'user assign class'],


            ];
            $systemOwnerRole->givePermissionTo($systemOwnerPermission);

            // Default Owner Create
            $ownerData =    [
                'name' => 'Owner',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'owner',
                'lang' => 'english',
                'email_verified_at' => now(),
                'profile' => 'avatar.png',
                'subscription' => 1,
                'parent_id' => $systemSuperAdmin->id,
            ];
            $systemOwner = User::create($ownerData);
            // Default Template Assign
            defaultTemplate($systemOwner->id);
            // Default Owner Role Assign
            $systemOwner->assignRole($systemOwnerRole);


            // Default Owner Role
            $managerRoleData =  [
                'name' => 'manager',
                'parent_id' => $systemOwner->id,
            ];
            $systemManagerRole = Role::create($managerRoleData);
            // Default Manager All Permissions
            $systemManagerPermission = [
                ['name' => 'manage user'],
                ['name' => 'create user'],
                ['name' => 'edit user'],
                ['name' => 'delete user'],
                ['name' => 'manage contact'],
                ['name' => 'create contact'],
                ['name' => 'edit contact'],
                ['name' => 'delete contact'],
                ['name' => 'manage note'],
                ['name' => 'create note'],
                ['name' => 'edit note'],
                ['name' => 'delete note'],
                ['name' => 'manage 2FA settings'],

                ['name' => 'manage trainer'],
                ['name' => 'create trainer'],
                ['name' => 'edit trainer'],
                ['name' => 'show trainer'],
                ['name' => 'delete trainer'],
                ['name' => 'manage trainee'],
                ['name' => 'create trainee'],
                ['name' => 'edit trainee'],
                ['name' => 'delete trainee'],
                ['name' => 'show trainee'],
                ['name' => 'manage class'],
                ['name' => 'create class'],
                ['name' => 'edit class'],
                ['name' => 'delete class'],
                ['name' => 'show class'],
                ['name' => 'assign user class'],
                ['name' => 'delete user class'],
                ['name' => 'manage category'],
                ['name' => 'create category'],
                ['name' => 'edit category'],
                ['name' => 'delete category'],
                ['name' => 'manage membership'],
                ['name' => 'create membership'],
                ['name' => 'edit membership'],
                ['name' => 'delete membership'],
                ['name' => 'show membership'],
                ['name' => 'manage workout'],
                ['name' => 'create workout'],
                ['name' => 'edit workout'],
                ['name' => 'delete workout'],
                ['name' => 'show workout'],
                ['name' => 'manage today workout'],
                ['name' => 'manage health update'],
                ['name' => 'create health update'],
                ['name' => 'edit health update'],
                ['name' => 'delete health update'],
                ['name' => 'show health update'],
                ['name' => 'manage attendance'],
                ['name' => 'create attendance'],
                ['name' => 'edit attendance'],
                ['name' => 'delete attendance'],
                ['name' => 'manage today attendance'],
                ['name' => 'manage invoice'],
                ['name' => 'create invoice'],
                ['name' => 'edit invoice'],
                ['name' => 'delete invoice'],
                ['name' => 'show invoice'],
                ['name' => 'delete invoice type'],
                ['name' => 'create invoice payment'],
                ['name' => 'delete invoice payment'],
                ['name' => 'manage expense'],
                ['name' => 'create expense'],
                ['name' => 'edit expense'],
                ['name' => 'delete expense'],
                ['name' => 'show expense'],
                ['name' => 'manage finance type'],
                ['name' => 'create finance type'],
                ['name' => 'edit finance type'],
                ['name' => 'delete finance type'],

            ];
            $systemManagerRole->givePermissionTo($systemManagerPermission);

            // Default Manager Create
            $managerData = [
                'name' => 'Manager',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'manager',
                'lang' => 'english',
                'email_verified_at' => now(),
                'profile' => 'avatar.png',
                'subscription_expire_date' => Carbon::now()->addMonths(1)->isoFormat('YYYY-MM-DD'),
                'subscription' => 0,
                'parent_id' => $systemOwner->id,
            ];
            $systemManager = User::create($managerData);
            // Default Manager Role Assign
            $systemManager->assignRole($systemManagerRole);
            defaultTrainerCreate($systemOwner->id);
            defaultTraineeCreate($systemOwner->id);


            // Subscription default data
            $subscriptionData = [
                'title' => 'Basic',
                'package_amount' => 0,
                'interval' => 'Monthly',
                'user_limit' => 10,
                'trainer_limit' => 10,
                'trainee_limit' => 10,
                'enabled_logged_history' => 1,
            ];
            \App\Models\Subscription::create($subscriptionData);


            NewPermission();
        } else {
            NewPermission();
        }
    }
}
