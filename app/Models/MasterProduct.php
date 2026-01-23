<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterProduct extends Model
{
    protected $fillable = ['nama', 'deskripsi'];

    // Relasi ke varian satuan
    public function productUnits()
    {
        return $this->hasMany(ProductUnit::class);
    }
}