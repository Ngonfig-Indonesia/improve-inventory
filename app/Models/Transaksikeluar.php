<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksikeluar extends Model
{
    use HasFactory;

    protected $table = 'transaksikeluars';
    protected $fillable = ['type_barang','no_mr','dept','pic','tgl_transaksi_masuk','keterangan'];

    public function barangkeluar()
    {
        return $this->hasMany(Barangkeluar::class, 'transaksi_id');
    }

}
