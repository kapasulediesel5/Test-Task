<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catalog', function (Blueprint $table) {
            $table->id();
            $table->string("Category")->nullable();
            $table->string("Category_")->nullable();
            $table->string("Product Category")->nullable();
            $table->string("Manufacturer")->nullable();
            $table->string("Product Name")->nullable();
            $table->string("Model Code (Manufacturer's SKU)")->nullable();
            $table->text("Product Description")->nullable();
            $table->text("Retail Price UAH (Ukrainian Hryvnia)")->nullable();
            $table->text("Warranty")->nullable();
            $table->string("Availability")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalog');
    }
};
