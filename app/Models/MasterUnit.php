<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterUnit extends Model
{
    protected $fillable = ['nama', 'singkatan'];

    public function productUnits()
    {
        return $this->hasMany(ProductUnit::class);
    }
}
