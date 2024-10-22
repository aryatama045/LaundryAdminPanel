<?php

use App\Models\Driver;
use App\Models\DriverOrder;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new DriverOrder())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained((new Order())->getTable());
            $table->foreignId('driver_id')->constrained((new Driver())->getTable());
            $table->boolean('is_accept')->default(0);
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
        Schema::dropIfExists((new DriverOrder())->getTable());
    }
}
