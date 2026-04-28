<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerFund extends Model
{
    protected $fillable = ['user_id', 'amount', 'type', 'description', 'date'];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
