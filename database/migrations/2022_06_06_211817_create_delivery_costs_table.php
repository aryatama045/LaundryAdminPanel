<?php

use App\Models\DeliveryCost;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new DeliveryCost())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->float('cost');
            $table->float('fee_cost');
            $table->float('minimum_cost');
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
        Schema::dropIfExists((new DeliveryCost())->getTable());
    }
}
