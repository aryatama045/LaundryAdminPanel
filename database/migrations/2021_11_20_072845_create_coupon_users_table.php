<?php

use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new CouponUser())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('coupon_id')->constrained((new Coupon())->getTable());
            $table->foreignId('user_id')->constrained((new User())->getTable());
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
        Schema::dropIfExists((new CouponUser())->getTable());
    }
}
