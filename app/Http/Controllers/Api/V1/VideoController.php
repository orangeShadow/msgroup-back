<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Api\Deal;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Обновляем данные.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $type, $id)
    {
        // Проверяем параметры
        $request->validate(['url' => 'required|url']);
        if (!in_array($type, ['acceptance', 'diagnostics', 'repair'])) abort(404);

        // Проверяем права
        $this->show_error_if_role_is_not($request, ['master']);

        // Текущий пользователь
        $user = $request->user();

        // Заказ
        $deal = Deal::query()
            ->where('id', '=', $id)
            ->where('master_id', '=', $user->id)
            ->where('deleted', '=', 0)
            ->where('status', '<>', config('statuses.completed.id'))
            ->firstOrFail();

        // Если нельзя менять ссылку на видео, выдаём ошибку
        if (
            ($type == 'acceptance' && $deal->status >= config('statuses.diagnostics.id'))
            || ($type == 'diagnostics' && $deal->status >= config('statuses.negotiation.id'))
            || ($type == 'repair' && $deal->status >= config('statuses.payment.id'))
        ) abort(403);

        // Подготавливаем данные
        $deal->{'video_'.$type} = $request->url;

        // Обновляем заказ
        return $deal->save();
    }
}
