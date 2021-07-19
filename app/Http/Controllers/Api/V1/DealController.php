<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealCreateRequest;
use App\Http\Requests\DealUpdateRequest;
use App\Http\Resources\DealClientResource;
use App\Http\Resources\DealCourierResource;
use App\Http\Resources\DealManagerResource;
use App\Http\Resources\DealMasterResource;
use App\Http\Resources\DealResource;
use App\Http\Resources\DealsResource;
use App\Http\Resources\DealsCourierResource;
use App\Models\Api\Deal;
use App\Models\Api\DealSpare;
use App\Models\Api\Malfunction;
use App\Models\Api\DealMalfunction;
use App\Models\Api\Spare;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Список заказов.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Определяем роль пользователя
        $user = $request->user();
        $role = config("roles.{$user->role}.name");

        // Если курьер
        if ($role == 'courier')
        {
            // Видит все заказы в статусе "Доставка"
            return DealsCourierResource::collection(
                Deal::query()
                    ->where('deleted', '=', false)
                    ->whereIn('status', [
                        config('statuses.delivery_a.id'),
                        config('statuses.delivery_b.id'),])
                    ->orderBy('updated_at')
                    ->get()
            );
        }
        // Мастер
        elseif ($role == 'master')
        {
            // Видит только назначенные ему заказы (кроме ряда статусов)
            return DealsResource::collection(
                Deal::query()
                    ->where('deleted', '=', false)
                    ->where('master_id', '=', $user->id)
                    ->whereNotIn('status', [
                        config('statuses.acceptance.id'),
                        config('statuses.payment.id'),
                        config('statuses.ready.id'),
                        config('statuses.completed.id'),])
                    ->orderBy('status')
                    ->orderBy('updated_at')
                    ->get()
            );
        }
        // Управляющий
        elseif ($role == 'manager')
        {
            // Видит все невыполненные заказы
            return DealsResource::collection(
                Deal::query()
                    ->where('deleted', '=', false)
                    ->where('status', '<>', config('statuses.completed'))
                    ->orderBy('status')
                    ->orderBy('updated_at')
                    ->get()
            );
        }
        // Клиент
        else
        {
            // Видит только свои заказы
            return DealsResource::collection(
                Deal::query()
                    ->where('deleted', '=', false)
                    ->where('client_id', '=', $user->id)
                    ->orderBy('status')
                    ->get()
            );
        }
    }

    /**
     * Создаём заявку.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealCreateRequest $request)
    {
        $data = $request->validate([
//            'client_id' => 'required',
            'master_id' => 'required',
            'manufacturer_id' => 'required',
            'model_id' => 'required',
            'condition_id' => 'required',
            'malfunction_id' => 'required',
            'point_a_id' => 'required',
            'point_b_id' => 'required',
            'serial' => 'required',
            'password' => 'required',
            'dev_id' => 'required',
            'dev_id_password' => 'required',
            'completeness' => 'required',
            'surname' => 'required',
            'name' => 'required',
            'patronymic' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'notification_type' => 'required',
//            'verify_token' => 'required',
        ]);

        $user = $request->user();
        $data['client_id'] = $user->id;

        return new DealResource(Deal::create($data));
    }

    /**
     * Данные заказа.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $deal_id)
    {
        // Определяем роль пользователя
        $user = $request->user();
        $role = config("roles.{$user->role}.name");

        if ($role == 'client')
        {
            return new DealClientResource(
                Deal::query()
                    ->where('id', '=', $deal_id)
                    ->where('client_id', '=', $user->id)
                    ->with('malfunctions')
                    ->first()
            );
        }
        elseif ($role == 'master')
        {
            return new DealMasterResource(
                Deal::query()
                    ->where('id', '=', $deal_id)
                    ->where('master_id', '=', $user->id)
                    ->first()
            );
        }
        elseif ($role == 'courier')
        {
            return new DealCourierResource(
                Deal::query()
                    ->where('id', '=', $deal_id)
                    ->whereIn('status', [
                        config('statuses.delivery_a.id'),
                        config('statuses.delivery_b.id'),
                    ])
                    ->first()
            );
        }
        elseif ($role == 'manager')
        {
            return new DealManagerResource(Deal::find($deal_id));
        }

        if (!isset($data->id)) abort(404);
    }

    /**
     * Обновляем данные заказа.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealUpdateRequest $request, $id)
    {
        // Обработка входящих данных
        $data = $request->validated();
        foreach ($data as $key => $val)
            if (empty($val)) unset($data[$key]);
        if (empty($data)) return [];

        // Обновляем данные заявки
        Deal::query()
            ->where('id', '=', $id)
            ->where('deleted', '=', false)
            ->update($data);

        // Возвращаем результат обработки запроса
        $data = Deal::where('deleted', '=', false)->find($id);
        if (!is_object($data)) return [];
        return new DealResource($data);
    }

    /**
     * "Удаляем" заказ.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Определяем роль пользователя
        $user = $request->user();
        $role = config("roles.{$user->role}.name");

        // Управляющий
        if ($role == 'manager')
        {
            return [
                'id' => $id,
                'deleted' => (bool)Deal::query()
                    ->where('id', '=', $id)
                    ->update(['deleted' => true]),
            ];
        }
        // Клиент
        elseif ($role == 'client')
        {
            return [
                'id' => $id,
                'deleted' => (bool)Deal::query()
                    ->where('id', '=', $id)
                    ->where('client_id', '=', $user->id)
                    ->where('status', '<>', config('statuses.acceptance'))
                    ->update(['deleted' => true]),
            ];
        }
        // Остальным ролям запрещено удалять
        else abort(403, 'У вас нет доступа к этому функционалу');
    }

    public function set_status(Request $request, $deal_id, $status)
    {
        // Текущий пользователь
        $user = $request->user();

        $data = [];
        $req = Deal::query()
            ->where('id', '=', $deal_id)
            ->where('deleted', '=', 0)
            ->where('status', '<>', config('statuses.completed.id'));

        // В зависимости от статуса...

        // Приёмка
        if ($status == 'point_a')
        {
            // Проверяем права
            $this->show_error_if_role_is_not($request, ['client', 'postamat']);
            // Обязательные поля
            $request->validate(['cell_id' => 'required|integer']);
            // Подготавливаем данные
            $data['status']  = config('statuses.delivery_a.id');
            $data['cell_id'] = intval($request->cell_id);
            // БД
            $req = $req
                ->where('client_id', '=', $user->id)
                ->where('status', '<=', config('statuses.delivery_a.id'));
        }
        // Отправить в ремонт
        elseif ($status == 'agree')
        {
            // Проверяем права
            $this->show_error_if_role_is_not($request, ['client']);
            // Подготавливаем данные
            $request->validate(['spares' => 'array']);
            if (isset($request->spares)) foreach ($request->spares as $s_id)
            {
                // Обезвреживаем
                $s_id = intval($s_id);
                if (empty($s_id)) continue;
                // Загружаем запчасть
                $s = Spare::find($s_id);
                if (!isset($s->id)) continue;
                // Добавляем данные о запчасти к заказу
                DealSpare::query()->updateOrCreate(
                    [
                        'deal_id' => $deal_id,
                        'spare_id' => $s_id,
                    ],
                    [
                        'title' => $s->title,
                        'price' => $s->price,
                    ]
                );
            }
            $data['status'] = config('statuses.agreed.id');
            // БД
            $req = $req
                ->where('client_id', '=', $user->id)
                ->where('status', '<=', config('statuses.agreed.id'));
        }
        // Отказаться от ремонта
        elseif ($status == 'disagree')
        {
            // Проверяем права
            $this->show_error_if_role_is_not($request, ['client']);
            // Подготавливаем данные
            $data['status'] = config('statuses.delivery_b.id');
            // БД
            $req = $req
                ->where('client_id', '=', $user->id)
                ->where('status', '<=', config('statuses.negotiation.id'));
        }
        // Начать диагностику
        // Ожидание запчастей
        // Начать ремонт
        elseif (in_array($status, ['waiting', 'repair', 'diagnostics']))
        {
            // Проверяем права
            $this->show_error_if_role_is_not($request, ['master']);
            // Подготавливаем данные
            $data['status'] = config('statuses.'.$status.'.id');
            // БД
            $req = $req
                ->where('master_id', '=', $user->id)
                ->where('status', '<=', config('statuses.'.$status.'.id'));
        }
        // Отправить на согласование
        elseif ($status = 'negotiation')
        {
            // Проверяем права
            $this->show_error_if_role_is_not($request, ['master']);
            // Подготавливаем данные
            $request->validate(['malfunctions' => 'required|array']);
            foreach ($request->malfunctions as $m_id)
            {
                // Обезвреживаем
                $m_id = intval($m_id);
                if (empty($m_id)) continue;
                // Загружаем неисправность
                $m = Malfunction::find($m_id);
                if (!isset($m->id)) continue;
                // Добавляем данные о неисправности к заказу
                DealMalfunction::query()->updateOrCreate(
                    [
                        'deal_id' => $deal_id,
                        'malfunction_id' => $m_id,
                    ],
                    [
                        'title' => $m->title,
                        'hours' => $m->hours,
                        'price' => $m->price,
                    ]
                );
                // Считаем общее время и общую сумму
                $data['hours'] = ($data['hours'] ?? 0) + $m->hours;
                $data['price'] = ($data['price'] ?? 0) + $m->price;
            }
            $data['status'] = config('statuses.negotiation.id');
            // БД
            $req = $req
                ->where('master_id', '=', $user->id)
                ->where('status', '<=', config('statuses.negotiation.id'));
        }
        // Завершить ремонт
        elseif ($status == 'repaired')
        {
            // Проверяем права
            $this->show_error_if_role_is_not($request, ['master']);
            // Загружаем заказ
            $deal = Deal::query()
                ->where('id', '=', $deal_id)
                ->where('master_id', '=', $user->id)
                ->where('deleted', '=', 0)
            ->first();
            // Если пункт работы мастера совпадает с пунктом выдачи
            if ($user->point_id == $deal->point_b)
            {
                // Ожидает оплату
                $data['status'] = config('statuses.payment.id');
            }
            // Если пункт работы мастера не совпадает с пунктом выдачи
            else
            {
                // Доставка в пункт выдачи
                $data['status'] = config('statuses.delivery_b.id');
            }
            // Подготавливаем данные
            if (!empty($request->reason)) $data['delay_reason'] = $request->reason;
            // БД
            $req = $req
                ->where('master_id', '=', $user->id)
                ->where('status', '<=', config('statuses.delivery_b.id'));
        }
        // Размещено в постамате на выдачу
        elseif ($status == 'point_b')
        {
            // Проверяем права
            $this->show_error_if_role_is_not($request, ['master', 'courier', 'postamat']);
            // Обязательные поля
            $request->validate(['cell_id' => 'required|integer']);
            // Подготавливаем данные
            $data['status']  = config('statuses.payment.id');
            $data['cell_id'] = intval($request->cell_id);
        }
        // Завершено
        elseif ($status == 'completed')
        {
            // Проверяем права
            $this->show_error_if_role_is_not($request, ['client']);
            // Подготавливаем данные
            $data['status'] = config('statuses.completed.id');
            if (!empty($request->comment)) $data['comment'] = $request->comment;
            // БД
            $req = $req->where('client_id', '=', $user->id);
        }
        // Всё прочее - ошибка
        else abort(404);

        // Обновляем заказ
        return $req->update($data);
    }
}
