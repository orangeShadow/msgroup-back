<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use App\Http\Resources\PointResource;
use App\Models\Api\Malfunction;
use App\Models\Api\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    /**
     * Список всех точек.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PointResource::collection(Point::all());
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
     * Список точек с сортировкой по неисправности и с наименее загруженным мастером.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($malfunction_id)
    {
        // Выгружаем список мастеров, работающих с данным видом неисправностей
        $mlfn = Malfunction::with('masters')->find($malfunction_id);
        if (empty($mlfn->masters)) return [];
        $masters = MasterResource::collection($mlfn->masters);

        // Определяем наименее загруженных мастеров для каждой точки
        $ps = [];
        foreach($masters as $m)
        {
            if (empty($m->point_id)) continue;

            // Считаем текущую нагрузку этого мастера
            $hours = 0;
            foreach($m->loading as $item) $hours += (int)$item->hours;
            $m->loading = $hours;

            // Если на этой точке уже рассматривался мастер
            if (isset($ps[$m->point_id]))
            {
                // Если текущий мастер загружен менее, чем выбранный на точке
                if ($ps[$m->point_id]->master_hours > $hours)
                {
                    // Выбираем текущего мастера
                    $ps[$m->point_id]->master = $m;
                    $ps[$m->point_id]->master_hours = $hours;
                }
            }
            // Если на этой точке мастера ещё не выбрали
            else
            {
                // Выбираем текущего мастера
                $ps[$m->point_id] = new \stdClass();
                $ps[$m->point_id]->master = $m;
                $ps[$m->point_id]->master_hours = $hours;
            }
        }

        // Определяем айдишники точек
        $point_ids = array_keys($ps);
        if (empty($point_ids)) return [];

        // Загружаем список этих точек
        $points = PointResource::collection(Point::query()->whereIn('id', $point_ids)->get());

        // Пробегаем по всем точкам
        foreach($points as $key => $p)
        {
            // Если для точки определён мастер, добавляем инфу о нём
            if (isset($ps[$p->id])) $points[$key]->master = $ps[$p->id]->master;
            // Иначе убираем точку
            else unset($points[$key]);
        }

        // Возвращаем список найденных точек
        return $points;
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
