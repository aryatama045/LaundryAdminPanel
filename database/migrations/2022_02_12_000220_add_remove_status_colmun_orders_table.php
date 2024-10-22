<?php

use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemoveStatusColmunOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table((new Order())->getTable(), function (Blueprint $table) {
            $table->dropColumn('order_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((new Order())->getTable(), function (Blueprint $table) {
            $table->enum('order_status', config('enums.order_status'));
        });
    }
}
