<?php

use App\Models\Service;
use App\Models\ServiceVariant;
use App\Models\Variant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new ServiceVariant())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained((new Service())->getTable());
            $table->foreignId('variant_id')->constrained((new Variant())->getTable());
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
        Schema::dropIfExists((new ServiceVariant())->getTable());
    }
}
