<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    protected $fillable = [
        'master_product_id',
        'satuan',
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

    // Relasi ke Sales (Penjualan mengambil stok dari unit ini)
    public function salesLogs()
    {
        return $this->hasMany(SalesLog::class);
    }
}