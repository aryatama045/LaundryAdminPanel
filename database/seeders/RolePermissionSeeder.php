<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->grantPermissionsToRoles();
    }

    private function grantPermissionsToRoles()
    {
        foreach (config('acl.roles') as $key => $roleName) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                $permissions = [];

                foreach (config('acl.permissions') as $permission => $roles) {
                    if (in_array($roleName, $roles)) {
                        $permissions[] = $permission;
                    }
                }
                $role->syncPermissions($permissions);

                $users = User::role($roleName)->get() ?? [];
                foreach($users as $user){
                    $user->syncPermissions($permissions);
                }
            }
        }
    }
}
