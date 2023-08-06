<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangkeluar extends Model
{
    use HasFactory;

    protected $table = 'barangkeluars';
    protected $fillable = ['transaksi_id','item_id','kode_item','nama_barang','eom','qty','tanggal_keluar'];

    public function transaksikeluar()
    {
        return $this->belongsTo(Transaksikeluar::class, 'transaksi_id');
    }

    public function item()
    {
        return $this->belongsTo(item::class, 'item_id');
    }
}
