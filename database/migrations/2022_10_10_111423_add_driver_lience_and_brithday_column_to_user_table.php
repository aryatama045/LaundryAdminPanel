<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDriverLienceAndBrithdayColumnToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table((new User())->getTable(), function (Blueprint $table) {
            $table->string('driving_lience')->nullable();
            $table->string('date_of_birth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table((new User())->getTable(), function (Blueprint $table) {
            $table->dropColumn('driving_lience'); 
            $table->dropColumn('date_of_birth');
        });
    }
}
