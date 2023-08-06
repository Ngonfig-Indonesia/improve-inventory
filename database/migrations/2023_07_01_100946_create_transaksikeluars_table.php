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
        Schema::create('transaksikeluars', function (Blueprint $table) {
            $table->id();
            $table->string('type_barang');
            $table->string('no_mr');
            $table->string('dept');
            $table->string('pic');
            $table->date('tgl_transaksi_keluar');
            $table->text('keterangan')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksikeluars');
    }
};
