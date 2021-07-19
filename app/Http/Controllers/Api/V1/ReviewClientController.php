<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewClientResource;
use App\Models\Api\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Добавляем отзыв о клиенте.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Проверяем обязательные поля
        $request->validate([
            'deal_id' => 'required',
            'mark'    => 'required',
            'comment' => 'required',
        ]);

        // Сохраняем отзыв
        return Review::query()->where('id', '=', $request->deal_id)->update([
            'client_mark'    => $request->mark,
            'client_comment' => $request->comment,
        ]);
    }

    /**
     * Список отзывов.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $user_id)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Возвращаем список отзывов
        return ReviewClientResource::collection(
            Review::query()
                ->where('client_id', '=', $user_id)
                ->orderBy('created_at', 'desc')
                ->get()
        );
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
    public function destroy($id)
    {
        //
    }
}
