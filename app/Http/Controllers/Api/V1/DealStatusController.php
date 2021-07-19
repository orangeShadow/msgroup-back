<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Api\Deal;
use App\Models\Api\Status;
use Illuminate\Http\Request;

class DealStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($deal_id=null, $status=null)
    {
        // Определяем целевой статус
        $status = strtoupper('status_'.$status);
        $status = Status::query()->where('name', '=', $status)->get()->first();
        if (empty($status)) return [
            'status' => 'error'
        ];

        // Определяем роль пользователя
        // Если пользователь имеет право на изменение статуса
        // Меняем статус
        Deal::query()->where('id', '=', $deal_id)->update(['status' => $status->id]);

        return [
            'deal_id' => $deal_id,
            'status' => $status,
        ];
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
