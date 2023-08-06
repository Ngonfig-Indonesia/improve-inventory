<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class transaksi_masuk extends Model
{
    use HasFactory;

    protected $table = 'transaksi_masuks';
    protected $primarykey = 'id';
    protected $fillable = ['type_barang', 'no_pr', 'no_po', 'no_grn', 'supplier', 'jenis', 'tgl_transaksi_masuk', 'keterangan'];

    public function barangmasuk()
    {
        return $this->hasMany(barang_masuk::class, 'transaksi_id');
    }
}
