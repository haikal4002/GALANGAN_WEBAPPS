<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    protected $fillable = [
        'tanggal',
        'nomor_resi',
        'master_product_id',
        'qty',
        'stok_awal',
        'harga_beli',
        'nominal',
        'margin',
        'harga_jual',
        'harga_atas',
        'supplier_id',
        'status_pembayaran',
        'status_barang',
        'jatuh_tempo',
        'qty_kulak'
    ];

    public function salesLogs()
    {
        return $this->hasMany(SalesLog::class);
    }

    public function masterProduct()
    {
        return $this->belongsTo(MasterProduct::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function scopeLowStock($query, $threshold = 10)
    {
        return $query->where('qty', '<=', $threshold);
    }
}
