<?php

use App\Models\MobileAppUrl;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileAppUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new MobileAppUrl())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->text('android_url')->nullable();
            $table->text('ios_url')->nullable();
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
        Schema::dropIfExists((new MobileAppUrl())->getTable());
    }
}
