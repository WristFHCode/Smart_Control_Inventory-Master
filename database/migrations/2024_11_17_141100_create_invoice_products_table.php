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
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id')->index('invoice_products_invoice_id_foreign');
            $table->unsignedBigInteger('cardboard_product_id')->index('invoice_products_cardboard_product_id_foreign');
            $table->integer('total_price')->nullable();
            $table->integer('price_per_unit')->nullable();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products');
    }
};
