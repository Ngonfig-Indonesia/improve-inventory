<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $fillable = ['kode_item','nama_barang','eom','qty','rak'];

    public function item_details()
    {
        return $this->hasMany(item_detail::class, 'item_detail_id');
    }

    public function barangmasuk()
    {
        return $this->hasMany(barang_masuk::class, 'item_id');
    }

    public function barangkeluar()
    {
        return $this->hasMany(Barangkeluar::class, 'item_id');
    }
    
}
