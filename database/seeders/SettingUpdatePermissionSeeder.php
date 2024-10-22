<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SettingUpdatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::findOrCreate('setting.update', 'web');
        $user = User::role('root')->first();
        $user->givePermissionTo('setting.update');
    }
}
