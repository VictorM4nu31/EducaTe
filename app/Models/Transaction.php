<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'description',
        'metadata',
        'rfc_sender',
        'rfc_receiver',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
