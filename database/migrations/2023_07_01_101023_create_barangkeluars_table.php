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
        Schema::create('barangkeluars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_id');   
            $table->unsignedBigInteger('item_id');
            $table->string('kode_item');
            $table->string('nama_barang');
            $table->string('eom')->default('pcs');
            $table->string('qty');

            $table->timestamps();

            $table->foreign('transaksi_id')->references('id')->on('transaksikeluars')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangkeluars');
    }
};
