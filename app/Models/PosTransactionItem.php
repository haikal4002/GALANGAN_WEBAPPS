<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosTransactionItem extends Model
{
    protected $guarded = ['id'];

    // Relasi ke ProductUnit untuk ambil nama barang di nota
    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class, 'product_unit_id');
    }
}
