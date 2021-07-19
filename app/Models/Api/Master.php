<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    use HasFactory;

    protected $table = 'users';

    public function loading()
    {
        return $this->hasMany(Deal::class, 'master_id', 'id')
            ->where('deleted', '=', false)
            ->where('status', '<>', config('statuses.completed.id'));
    }
}
