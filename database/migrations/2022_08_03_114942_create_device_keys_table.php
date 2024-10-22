<?php

use App\Models\Customer;
use App\Models\DeviceKey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new DeviceKey())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained((new Customer())->getTable());
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
        Schema::dropIfExists((new DeviceKey())->getTable());
    }
}
