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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('subtotal', 10)->nullable();
            $table->decimal('taxes', 10)->nullable();
            $table->decimal('total', 10)->nullable();
            $table->timestamps();
            $table->string('nota', 50)->nullable();
            $table->integer('total_items')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('invoices_user_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
