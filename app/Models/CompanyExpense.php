<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyExpense extends Model
{
    protected $fillable = ['category', 'amount', 'date', 'description', 'invoice_path', 'user_id', 'status'];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
