<?php

use App\Models\Media;
use App\Models\Product;
use App\Models\Service;
use App\Models\Variant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Product())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained((new Service())->getTable());
            $table->foreignId('variant_id')->constrained((new Variant())->getTable());
            $table->foreignId('thumbnail_id')->nullable()->constrained((new Media())->getTable());
            $table->string('name');
            $table->string('slug')->nullable();
            $table->float('discount_price')->nullable();
            $table->float('price');
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists((new Product())->getTable());
    }
}
