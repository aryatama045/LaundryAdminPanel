<?php

use App\Models\Additional;
use App\Models\AdditionalService;
use App\Models\Service;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new AdditionalService())->getTable(), function (Blueprint $table) {
            $table->foreignId('service_id')->constrained((new Service())->getTable());
            $table->foreignId('additional_id')->constrained((new Additional())->getTable());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists((new AdditionalService())->getTable());
    }
}
