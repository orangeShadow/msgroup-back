<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FineResource;
use App\Http\Resources\MasterResource;
use App\Models\Api\User;
use App\Models\Fine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MastersController extends Controller
{
    /**
     * Список мастеров
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Возвращаем данные
        return MasterResource::collection(
            User::query()
            ->where('role', '=', config('roles.master'))
            ->get()
        );
    }

    /**
     * Карточка мастера
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $user_id)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Возвращаем карточку
        return new MasterResource(User::findOrFail($user_id));
    }

    /**
     * Штрафуем мастера
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $master_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $master_id)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Проверяем обязательные поля
        $request->validate(['fine'  => 'required',]);

        // Добавляем данные
        return new FineResource(Fine::query()->create([
            'user_id' => (int)$master_id,
            'amount' => (float)$request->fine,
            'date_begin' => date('Y-m-d'),
            'date_end' => date('Y-m-d', strtotime('+1 month')),
        ]));
    }

    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
