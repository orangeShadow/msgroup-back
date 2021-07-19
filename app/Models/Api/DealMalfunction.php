<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealMalfunction extends Model
{
    use HasFactory;

    protected $table = 'deal_malfunction';

    protected $fillable = [
        'deal_id',
        'malfunction_id',
        'title',
        'hours',
        'price',
    ];
}
