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
        Schema::create('fixed_expenditures', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('expenditure_id');
            $table->string('cycle_unit');
            $table->integer('payment_day');
            $table->integer('payment_month')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('expenditure_id')->references('id')->on('expenditures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_expenditures');
    }
};
