<?php

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Payment())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained((new Order())->getTable());
            $table->string('object');
            $table->string('brand');
            $table->string('status');
            $table->date('exp');
            $table->integer('last_no');
            $table->string('transaction');
            $table->float('amount', 10, 2);
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
        Schema::dropIfExists((new Payment())->getTable());
    }
}
