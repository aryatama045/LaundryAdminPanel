<?php

use App\Models\Driver;
use App\Models\DriverDeviceKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverDeviceKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new DriverDeviceKey())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained((new Driver())->getTable());
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
        Schema::dropIfExists((new DriverDeviceKey())->getTable());
    }
}
