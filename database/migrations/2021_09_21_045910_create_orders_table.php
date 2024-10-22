<?php

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Order())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('order_code');
            $table->string('prefix')->nullable();
            $table->foreignId('customer_id')
                ->constrained((new Customer())->getTable());
            $table->foreignId('coupon_id')->nullable()
                ->constrained((new Coupon())->getTable());
            $table->float('discount')->nullable();
            $table->date('pick_date');
            $table->date('delivery_date')->nullable();
            $table->string('pick_hour')->nullable();
            $table->string('delivery_hour')->nullable();
            $table->float('amount');
            $table->float('total_amount');
            $table->enum('payment_status', config('enums.payment_status'));
            $table->enum('order_status', config('enums.order_status'));
            $table->enum('payment_type', config('enums.payment_types'))->nullable();
            $table->foreignId('address_id')
                ->constrained((new Address())->getTable());
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
        Schema::dropIfExists((new Order())->getTable());
    }
}
