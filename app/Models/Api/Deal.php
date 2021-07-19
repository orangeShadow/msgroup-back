<?php

namespace App\Models\Api;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'client_id',
        'master_id',
        'manufacturer_id',
        'model_id',
        'malfunction_id',
        'condition_id',
        'point_a_id',
        'point_b_id',
        'serial',
        'password',
        'dev_id',
        'dev_id_password',
        'completeness',
        'video_acceptance',
        'video_diagnostics',
        'video_repair',
        'client_mark',
        'client_comment',
        'master_mark',
        'master_comment',
        'delay_reason',
        'status',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function malfunction()
    {
        return $this->belongsTo(Malfunction::class);
    }

    public function malfunctions()
    {
        return $this->belongsToMany(Malfunction::class);
    }

    public function spares()
    {
        return $this->belongsToMany(Spare::class);
    }

    public function point_a()
    {
        return $this->belongsTo(Point::class, 'point_a_id', 'id');
    }

    public function point_b()
    {
        return $this->belongsTo(Point::class, 'point_b_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function master()
    {
        return $this->belongsTo(User::class, 'master_id', 'id');
    }

    public function master_point()
    {
        return $this->hasOneThrough(Point::class, User::class);
    }

    public function type()
    {
        return $this->hasOneThrough(Type::class, Device::class, 'id', 'id', 'device_id', 'id');
    }
}
