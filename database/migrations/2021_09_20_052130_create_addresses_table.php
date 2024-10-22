<?php

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Address())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained((new Customer())->getTable());
            $table->string('address_name')->nullable();
            $table->string('road_no')->nullable();
            $table->string('house_no')->nullable();
            $table->string('flat_no')->nullable();
            $table->string('house_name')->nullable();
            $table->string('block')->nullable();
            $table->unsignedBigInteger('sub_district_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('area')->nullable();
            $table->string('address_line')->nullable();
            $table->string('address_line2')->nullable();
            $table->text('delivery_note')->nullable();
            $table->string('post_code')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists((new Address())->getTable());
    }
}
