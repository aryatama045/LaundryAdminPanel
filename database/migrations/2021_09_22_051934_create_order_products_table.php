<?php

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new OrderProduct())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained((new Order())->getTable());
            $table->foreignId('product_id')->constrained((new Product())->getTable());
            $table->integer('quantity')->default(1);
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
        Schema::dropIfExists((new OrderProduct())->getTable());
    }
}
