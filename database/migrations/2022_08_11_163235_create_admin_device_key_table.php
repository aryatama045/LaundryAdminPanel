<?php

use App\Models\AdminDeviceKey;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminDeviceKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new AdminDeviceKey())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained((new User())->getTable());
            $table->string('key');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new AdminDeviceKey())->getTable());
    }
}
