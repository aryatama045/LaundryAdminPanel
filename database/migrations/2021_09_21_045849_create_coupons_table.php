<?php

use App\Models\Coupon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Coupon())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('discount_type', config('enums.coupons.discount_types'));
            $table->float('discount');
            $table->float('min_amount');
            $table->timestamp('started_at');
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists((new Coupon())->getTable());
    }
}
