<?php

use App\Models\VerificationCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVerificationCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new VerificationCode())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('contact');
            $table->string('otp')->unique();
            $table->string('token')->unique()->nullable();
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
        Schema::dropIfExists((new VerificationCode())->getTable());
    }
}
