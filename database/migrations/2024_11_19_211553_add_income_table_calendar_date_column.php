<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->date('calendar_date')->nullable()->after('category_id');
        });

        DB::table('incomes')->update(['calendar_date' => now()]); // 例: 現在の日付を設定

        Schema::table('incomes', function (Blueprint $table) {
            $table->date('calendar_date')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->dropColumn('calendar_date');
        });
    }
};
