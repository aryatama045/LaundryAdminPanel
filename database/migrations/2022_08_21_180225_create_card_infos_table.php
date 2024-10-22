<?php

use App\Models\CardInfo;
use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new CardInfo())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained((new Customer())->getTable());
            $table->string('name');
            $table->string('card');
            $table->string('cvc');
            $table->integer('last_no')->nullable();
            $table->string('brand')->nullable();
            $table->integer('exp_month');
            $table->integer('exp_year');
            $table->softDeletes();
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
        Schema::dropIfExists((new CardInfo())->getTable());
    }
}
