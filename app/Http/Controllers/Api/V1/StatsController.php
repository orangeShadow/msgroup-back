<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Api\Deal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StatsController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Проверяем права доступа
        $this->show_error_if_role_is_not($request, ['manager']);

        // Проверяем параметр вида статистики
//        if (!in_array($type, ['points', 'masters', 'devices']))
//            abort(404);

        // Проверяем обязательные поля
        $request->validate([
            'type' => [
                'required',
                Rule::in(['points', 'masters', 'devices']),
            ],
            'year'  => 'required|date_format:Y',
            'month' => 'required|integer|between:0,12',
        ]);

        $req = Deal::query()
            ->where('deals.deleted', '=', false)
            ->orderBy('amount', 'desc')
            ->orderBy('count', 'desc');

        // Фильтруем по дате
        if (empty($request->month))
        {
            $req = $req->whereYear('deals.created_at', '=', $request->year);
        }
        else
        {
            $req = $req
                ->whereYear('deals.created_at', '=', $request->year)
                ->whereMonth('deals.created_at', '=', $request->month);
        }

        // Группируем по типу данных

        // По филиалам
        if ($request->type == 'points')
        {
            $req = $req
                ->select(DB::raw(
                    'points.id, points.address, SUM(deal_malfunction.price) amount, COUNT(deals.id) count'
                ))
                ->leftJoin('users', 'users.id', '=', 'deals.master_id')
                ->leftJoin('points', 'points.id', '=', 'users.point_id')
                ->leftJoin('deal_malfunction', 'deal_malfunction.deal_id', '=', 'deals.id')

                ->groupBy('points.id');
        }
        // По мастерам
        elseif ($request->type == 'masters')
        {
            $req = $req
                ->select(DB::raw('master_id, SUM(price) amount, COUNT(id) count'))
                ->with('master')
                ->groupBy('master_id');
        }
        // По категориям (компьютеры, мобильные устройства, бытовая техника)
        elseif ($request->type == 'devices')
        {
            $req = $req
                ->select(DB::raw(
                    'devices.type_id, SUM(deals.price) amount, COUNT(deals.id) count'))
                ->leftJoin('devices', 'devices.id', '=', 'deals.device_id')
                ->groupBy('devices.type_id');
        }

        // Кол-во, сумма
        // Все
        // Выполненные

        return [
            'all'   => $req->get(),
            'ready' => $req->where('deals.status', '=', config('statuses.completed.id'))->get(),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
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
