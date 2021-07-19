<?php

namespace App\Models\Api;

use App\Http\Resources\MasterPointResource;
use App\Models\DealMalfunction;
use App\Models\Fine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function client_sum()
    {
        // Считаем, на какую сумму было оказано услуг
        return floor(
            $this
            ->hasManyThrough(DealMalfunction::class,Deal::class, 'client_id')
            ->sum('deal_malfunction.price')
        );
    }

    public function client_mark()
    {
        // Считаем среднюю оценку клиента
        return round(
            $this
                ->hasMany(Deal::class, 'client_id')
                ->average('client_mark')
        );
    }

//    public function client_discount()
//    {
//        // Определяем текущую скидку клиента
//        return $this
//            ->hasOne(Discount::class)
//            ->where('date_end', '>=', date('Y-m-d'))->value('amount');
//    }

    public function master_fine()
    {
        // Определяем размер штрафа мастера
        return $this
            ->hasMany(Fine::class)
            ->where('date_begin', '<=', date('Y-m-d'))
            ->where('date_end', '>=', date('Y-m-d'))
            ->sum('amount');
    }

    public function master_point()
    {
        // Точка
        $data = $this->hasOne(Point::class, 'id', 'point_id')->first();
        return isset($data->id)? new MasterPointResource($data) : null;
    }
}
