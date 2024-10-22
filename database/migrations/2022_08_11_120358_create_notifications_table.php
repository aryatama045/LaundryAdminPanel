<?php

use App\Models\Customer;
use App\Models\Notification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Notification())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained((new Customer())->getTable());
            $table->string('message');
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
        Schema::dropIfExists((new Notification())->getTable());
    }
}
