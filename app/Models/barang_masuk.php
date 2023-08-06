<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_masuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuks';
    protected $primarykey = 'id';
    protected $fillable = ['transaksi_id','item_id','kode_item','nama_barang','eom','qty'];

    public function transaksimasuk()
    {
        return $this->belongsTo(transaksi_masuk::class, 'transaksi_id');
    }

    public function item()
    {
        return $this->belongsTo(item::class, 'item_id');
    }
}
