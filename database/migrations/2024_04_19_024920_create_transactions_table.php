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
            $table->string('invoice');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('bike_id');
            $table->unsignedBigInteger('duration_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('total_price')->nullable();
            // $table->string('amount');
            $table->string('charge')->default('0');
            $table->string('total')->nullable();
            $table->enum('payment', ['tunai', 'qris'])->default('tunai');
            $table->enum('status', ['1', '2'])->comment('1=Sedang Dalam Peminjaman, 2=Sudah Pengembalian, 3=kadaluarsa');
            $table->string('jaminan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
