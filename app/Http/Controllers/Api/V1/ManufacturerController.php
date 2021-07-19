<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManufacturerResource;
use App\Http\Resources\ManufacturersResource;
use App\Models\Api\Manufacturer;
use Illuminate\Http\Request;

class ManufacturerController extends Controller
{
    /**
     * Список производителей.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ManufacturersResource::collection(
            Manufacturer::query()->where('active', '=', 1)->get()
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
     * Список моделей производителя.
     *
     * @param  \App\Models\Api\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ManufacturerResource(
            Manufacturer::query()
                ->where('active', '=', 1)
                ->with('models')
                ->findOrFail($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Api\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Api\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manufacturer $manufacturer)
    {
        //
    }
}
