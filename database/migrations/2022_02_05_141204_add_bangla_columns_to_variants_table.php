<?php

use App\Models\Variant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBanglaColumnsToVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table((new Variant())->getTable(), function (Blueprint $table) {
            $table->string('name_bn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((new Variant())->getTable(), function (Blueprint $table) {
            $table->dropColumn('name_bn');
        });
    }
}
