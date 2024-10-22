<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(NotificationManageSeeder::class);
        if (app()->environment('local')) {
            $this->call(UsersTableSeeder::class);
            $this->call(VariantSeeder::class);
            $this->call(ServiceSeeder::class);
            $this->call(CustomerSeeder::class);
            $this->call(AddressSeeder::class);
            $this->call(ProductSeeder::class);
            $this->call(BannerSeeder::class);
            $this->call(CouponSeeder::class);
            $this->call(OrderSeeder::class);
            $this->call(RatingSeeder::class);
            $this->call(AdditionalSeeder::class);
            $this->call(AdditionalServiceSeeder::class);
        }else{
            $this->call(ProductionUsersTableSeeder::class);
        }

        $this->installPassportClient();
    }

    private function installPassportClient()
    {
        $this->command->warn('Installing passport client');
        Artisan::call('passport:install');
        $this->command->info('Passport client installed');
    }
}
