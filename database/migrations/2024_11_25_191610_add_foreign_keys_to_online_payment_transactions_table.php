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
        Schema::table('online_payment_transactions', function (Blueprint $table) {
            $table->foreign(['category_id'])->references(['id'])->on('online_payment_categories')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('online_payment_transactions', function (Blueprint $table) {
            $table->dropForeign('online_payment_transactions_category_id_foreign');
        });
    }
};
