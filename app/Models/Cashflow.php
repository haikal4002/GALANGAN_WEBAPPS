<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    protected $fillable = [
        'tanggal',
        'transaction_code_id',
        'keterangan',
        'debit',
        'kredit'
    ];

    public function transactionCode()
    {
        return $this->belongsTo(TransactionCode::class);
    }
}
