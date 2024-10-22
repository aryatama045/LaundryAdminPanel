<?php

use App\Models\Driver;
use App\Models\DriverHistory;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new DriverHistory())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained((new Driver())->getTable());
            $table->foreignId('order_id')->constrained((new Order())->getTable());
            $table->string('status');
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
        Schema::dropIfExists((new DriverHistory())->getTable());
    }
}
