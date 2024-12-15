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
        Schema::create('preset_expenditure_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128)->comment('支出名');
            $table->integer('category_id')->unsigned()->comment('支出カテゴリー');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preset_expenditure_items');
    }
};
