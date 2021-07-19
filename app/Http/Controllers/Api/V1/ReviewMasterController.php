<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewMasterResource;
use App\Models\Api\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewMasterController extends Controller
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
     * Добавляем отзыв о мастере.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReviewRequest $request)
    {
        // Проверяем обязательные поля
        $request->validate([
            'deal_id' => 'required',
            'mark'    => 'required',
            'comment' => 'required',
        ]);

        // Определяем текущего пользователя для проверки прав на добавление отзыва
        $user = $request->user();

        // Сохраняем отзыв
        return Review::query()
            ->where('id', '=', $request->deal_id)
            ->where('client_id', '=', $user->id)
            ->update([
            'master_mark' => $request->mark,
            'master_comment' => $request->comment,
        ]);
    }

    /**
     * Список отзывов о мастере.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $master_id)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Возвращаем список отзывов
        return ReviewMasterResource::collection(
            Review::query()
                ->where('master_id', '=', $master_id)
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
