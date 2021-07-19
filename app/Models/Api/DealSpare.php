<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealSpare extends Model
{
    use HasFactory;

    protected $table = 'deal_spare';

    protected $fillable = [
        'deal_id',
        'spare_id',
        'title',
        'price',
    ];
}
