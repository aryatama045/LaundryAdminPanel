<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [];
        $sl = 0;
        $getRoles = config('acl.roles');
        if (empty($getRoles) || !is_array($getRoles)) {
            return;
        }
        foreach ($getRoles as $key => $role) {
            $roles[$sl]['name'] = $role;
            $roles[$sl]['guard_name'] = 'web';
            $sl++;
        }
        return Role::insert($roles);
    }
}
