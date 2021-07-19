<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatRequest;
use App\Http\Resources\ChatResource;
use App\Models\Api\Chat;
use App\Models\Api\Deal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatClientController extends Controller
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
     * Добавляем сообщение в чат.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChatRequest $request)
    {
        $data = $request->validated();
        $data['message'] = $this->remove_phones($data['message']);
        $data['command'] = false;

        // Определяем пользователя, отправляющего сообщение
        $user = $request->user();
        $data['user_id'] = $user->id;

        // Определяем роль пользователя
        $role = config("roles.{$user->role}.name");

        // Если пользователь может по этому заказу писать
        if ($role == 'manager' || Deal::query()
            ->where('id', '=', $data['deal_id'])
            ->where('deleted', '=', 0)
            ->where('status', '<>', config('statuses.completed'))
            ->where(function ($query) use ($user) {
                $query->where('client_id', '=', $user->id)
                    ->orWhere('master_id', '=', $user->id);
            })->exists())
        {
            // Сохраняем и возвращаем сообщение
            return new ChatResource(Chat::create($data));
        }
        // Если по заказу писать нельзя, возвращаем ошибку
        else abort(403, 'У вас нет доступа к этому функционалу');
    }

    /**
     * Список сообщений чата по этому заказу.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $deal_id)
    {
        // Определяем пользователя
        $user = $request->user();

        // Определяем роль пользователя
        $role = config("roles.{$user->role}.name");

        // Проверяем, может ли пользователь читать этот чат
        if ($role != 'manager' && !Deal::query()
                ->where('id', '=', $deal_id)
                ->where('command', '=', false)
                ->where(function ($query) use ($user) {
                    $query->where('client_id', '=', $user->id)
                        ->orWhere('master_id', '=', $user->id);
                })->exists())
        {
            // Если по заказу писать нельзя, возвращаем ошибку
            abort(403, 'У вас нет доступа к этому функционалу');
        }

        // Вовзращаем список сообщений
        return ChatResource::collection(
            Chat::query()
                ->where('deal_id', '=', $deal_id)
                ->where('command', '=', false)
                ->with('author')
                ->orderBy('dt')
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

    // Удаляем номера телефонов из текста
    protected function remove_phones($data)
    {
        define ('TEST_LIMIT','12');

        // Фильтр символов проверяемой лексемы
        function phone_filter ($s)
        {
            return preg_replace (array("/\-/u","/[^\d\+]/u"),"",$s);
        }

        // Проверка лексемы на соответствие шаблону
        function is_phone ($s)
        {
            return preg_match("/^(\+7|8)(\d{10})$/u",$s) ? 1 : 0;
        }

        // Убрали лишние разделители
        $data = preg_replace ("/\s+/u"," ", $data);
        // Получили массив лексем
        $tokens = preg_split("/\s/u", $data);
        // Отфильтровали пустые лексемы
        $tokens = array_filter ($tokens, function ($item) {return !empty($item);});

        // Цикл по лексемам
        $result = [];
        $len = count($tokens);
        for ($i=0; $i<$len; $i++)
        {
            if (is_phone(phone_filter($tokens[$i])))
                $result[] = $tokens[$i]; //сама фильтрованная лексема есть номер
            else { //или пробуем сливать лексему с несколькими последующими
                $test = $tokens[$i]; $j = $i+1;
                while (1) {
                    if (isset($tokens[$j])) $test .= $tokens[$j];
                    $test = phone_filter ($test);
                    if (is_phone($test)) { $result[] = $test; $i=$j; break; }
                    else if ($j>=$len or strlen($test)>TEST_LIMIT) break;
                    $j++;
                }
            }
        }

        $data = str_replace($result, '', $data);
        return preg_replace('~([-+()\d]{10,})~', '', $data);
    }
}
