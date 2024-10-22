<?php

use App\Models\Subscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Subscription())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->float('price');
            $table->integer('validity');
            $table->string('validity_type');
            $table->integer('clothe');
            $table->integer('delivery');
            $table->integer('towel');
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
        Schema::dropIfExists((new Subscription())->getTable());
    }
}
