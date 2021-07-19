<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Api\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientsController extends Controller
{
    /**
     * Список клиентов.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Возвращаем данные
        return ClientResource::collection(
            User::query()
            ->where('role', '=', config('roles.client'))
            ->get()
        );
    }

    /**
     * Карточка клиента.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $user_id)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Возвращаем карточку клиента
        return new ClientResource(User::findOrFail($user_id));
    }

    /**
     * Назначаем скидку.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $client_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $client_id)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Проверяем обязательные поля
        $request->validate([
            'discount'  => 'required',
        ]);

        // Обновляем данные
        return User::query()->where('id', '=', $client_id)->update([
            'discount' => (int)$request->discount,
        ]);
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
