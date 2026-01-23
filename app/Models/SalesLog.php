<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesLog extends Model
{
    protected $fillable = [
        'product_unit_id', // <--- Update ini
        'tanggal_jual',
        'qty_terjual',
        'harga_satuan',
        'subtotal'
    ];

    // Update relasi ke ProductUnit
    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class);
    }
}