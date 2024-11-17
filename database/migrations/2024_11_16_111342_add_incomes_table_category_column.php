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
        Schema::table('incomes', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->comment('収入カテゴリー')->after('amount');
            $table->foreign('category_id')->references('id')->on('income_categories')->OnDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropForeign('incomes_category_id_foreign');
        });
    }
};
