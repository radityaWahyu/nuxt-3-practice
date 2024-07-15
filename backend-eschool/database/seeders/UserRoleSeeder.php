<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class UserRoleSeeder extends Seeder
{
    private $permissions = [
        'manage-jurusan',
        'read-jurusan'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $user = User::find(1);

        $role = Role::create(['name' => 'administrator']);
        //$permissions = Permission::where('name', 'manage-jurusan')->first();

        $role->givePermissionTo('manage-jurusan');
        $user->assignRole('administrator');
        //
    }
}
