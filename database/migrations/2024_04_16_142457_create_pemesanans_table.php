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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->string('payment');
            $table->decimal('total_price', 10, 2);
            $table->text('note');
            $table->enum('payment_status', ['1', '2', '3','4'])->comment('1=menunggu pembayaran, 2=sudah dibayar, 3=kadaluarsa, 4=Cancel');
            // $table->string('snap_token', 36)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
