<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class item_detail extends Model
{
    use HasFactory;

    protected $table = 'item_details';

    protected $fillable = ['item_detail_id','min_qty','max_qty'];


    public function items()
    {
        return $this->belongsTo(items::class, 'item_detail_id');
    }
}
