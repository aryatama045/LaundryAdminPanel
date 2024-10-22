<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_manages', function (Blueprint $table) {
            $table->id();
            $table->boolean('order_status_fcm')->default(true);
            $table->boolean('order_status_mail')->default(true);
            $table->boolean('new_order_fcm')->default(true);
            $table->boolean('new_order_mail')->default(true);
            $table->boolean('driver_assign_fcm')->default(false);
            $table->boolean('driver_assign_mail')->default(true);
            $table->boolean('coupon_notify')->default(true);
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
        Schema::dropIfExists('notification_manages');
    }
}
