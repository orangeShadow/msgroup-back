<?php

namespace App\Models\Api;

use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['deal_id', 'user_id', 'message', 'dt', 'command'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
