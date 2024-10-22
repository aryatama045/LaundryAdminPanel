<?php

use App\Models\Media;
use App\Models\WebSetting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureColumnToWebSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table((new WebSetting())->getTable(), function (Blueprint $table) {
            $table->foreignId('signature_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((new WebSetting())->getTable(), function (Blueprint $table) {
            $table->dropColumn('signature_id');
        });
    }
}
