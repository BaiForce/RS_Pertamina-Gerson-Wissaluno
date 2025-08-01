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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained()->onDelete('cascade');
            $table->foreignId('rute_id')->constrained()->onDelete('cascade');
            $table->dateTime('date');
            $table->integer('actual_time'); // in minutes
            $table->integer('standard_time'); // in minutes
            $table->integer('total_cost');
            $table->integer('late')->default(0); // calculated field (actual_time - standard_time)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutes');
    }
};
