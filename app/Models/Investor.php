<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = ['user_id', 'investment_amount', 'roi_due', 'amount_paid'];

    protected $casts = [
        'investment_amount' => 'decimal:3',
        'roi_due' => 'decimal:3',
        'amount_paid' => 'decimal:3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
