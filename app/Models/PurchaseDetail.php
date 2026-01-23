<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_unit_id',
        'qty',
        'harga_beli_satuan',
        'subtotal'
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class);
    }
}