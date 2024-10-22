<?php

use App\Models\OrderSchedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new OrderSchedule())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('day');
            $table->integer('start_time');
            $table->integer('end_time');
            $table->integer('per_hour');
            $table->boolean('is_active');
            $table->enum('type', ['pickup', 'delivery']);
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
        Schema::dropIfExists((new OrderSchedule())->getTable());
    }
}
