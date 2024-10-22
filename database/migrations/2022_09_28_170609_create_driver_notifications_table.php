<?php

use App\Models\Driver;
use App\Models\DriverNotification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new DriverNotification())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained((new Driver())->getTable());
            $table->text('message');
            $table->boolean('isRead')->nullable()->default(false);
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
        Schema::dropIfExists((new DriverNotification())->getTable());
    }
}
