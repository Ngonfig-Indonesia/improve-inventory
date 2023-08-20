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
        Schema::create('transaksi_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('type_barang');
            $table->string('no_grn');
            $table->string('supplier');
            $table->enum('jenis', ['comsumable', 'project'])->default('comsumable');
            $table->date('tgl_transaksi_masuk');
            $table->text('keterangan')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_masuks');
    }
};
