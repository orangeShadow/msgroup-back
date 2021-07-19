<?php

namespace App\Models\Api;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    public function models()
    {
        return $this->hasMany(Device::class);
    }
}
