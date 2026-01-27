<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    protected $fillable = [
        'master_product_id',
        'master_unit_id',
        'nilai_konversi',
        'is_base_unit',
        'stok',
        'harga_beli_terakhir',
        'margin',
        'harga_jual',
        'harga_atas'
    ];

    // Relasi ke Induk (Master Product)
    public function masterProduct()
    {
        return $this->belongsTo(MasterProduct::class);
    }

    public function masterUnit()
    {
        return $this->belongsTo(MasterUnit::class);
    }

    // Relasi ke Item POS
    public function posItems()
    {
        return $this->hasMany(PosTransactionItem::class);
    }
}