<?php

namespace Database\Seeders;

use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = (new UserRepository())->query()->whereHas('roles', function($role){
            $role->where('name', 'admin');
        })->get();

        foreach($users as $user){
            $user->givePermissionTo('root');
        }

        $permissions = config('acl.permissions');

        if (empty($permissions) || !is_array($permissions)) {
            return;
        }

        foreach ($permissions as $permission => $value) {
            Permission::findOrCreate($permission, 'web');
        }
    }
}
