<?php

use App\Models\Media;
use App\Models\SocialLink;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new SocialLink())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_id')->constrained((new Media())->getTable());
            $table->string('name')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists((new SocialLink())->getTable());
    }
}
