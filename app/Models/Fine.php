<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'date_begin',
        'date_end',
    ];

    public function total_amount()
    {
        // Общий размер штрафа на текущий день
        return $this
            ->hasMany(Fine::class, 'user_id', 'user_id')
            ->where('date_begin', '<=', date('Y-m-d'))
            ->where('date_end', '>=', date('Y-m-d'))
            ->sum('amount');
    }
}
