<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PushRequest;
use App\Http\Resources\PushResource;
use App\Models\Api\Push;
use App\Models\Api\Review;
use Illuminate\Http\Request;

class PushController extends Controller
{
    /**
     * Список уведомлений пользователя.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)//PushRequest $request
    {
        // Определяем пользователя, отправляющего сообщение
        $user = $request->user();

        // Возвращаем список сообщений
        return PushResource::collection(
            Push::query()->where('user_id', '=', $user->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Уведомление.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // Определяем пользователя, отправляющего сообщение
        $user = $request->user();

        // Проверяем, есть ли такое сообщение и доступно ли оно пользователю
        $data = Push::query()
            ->where('id', '=', $id)
            ->where('user_id', '=', $user->id)
            ->first();
        if (!isset($data->title)) abort(404, 'Сообщение не найдено');

        // Отмечаем сообщение как прочитанное
        Push::query()->where('id', '=', $id)->update(['fresh' => false]);
        $data->fresh = false;

        // Возвращаем сообщение
        return new PushResource($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // Определяем пользователя, отправляющего сообщение
        $user = $request->user();

        return [
            'id' => $id,
            'deleted' => (bool)Push::query()
                ->where('id', '=', $id)
                ->where('user_id', '=', $user->id)
                ->delete(),
        ];
    }
}
