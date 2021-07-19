<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Malfunction extends Model
{
    use HasFactory;

    public function masters()
    {
        return $this->belongsToMany(
            Master::class,
            'user_malfunction',
            'malfunction_id',
            'user_id',
            'id',
            'id'
        );
    }

    public function spares()
    {
        return $this->belongsToMany(Spare::class);
    }
}
