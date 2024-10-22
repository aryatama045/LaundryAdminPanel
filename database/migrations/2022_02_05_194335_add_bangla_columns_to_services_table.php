<?php

use App\Models\Service;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBanglaColumnsToServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table((new Service())->getTable(), function (Blueprint $table) {
            $table->string('name_bn')->nullable()->after('name');
            $table->longText('description_bn')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((new Service())->getTable(), function (Blueprint $table) {
            $table->dropColumn('name_bn');
            $table->dropColumn('description_bn');
        });
    }
}
