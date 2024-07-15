<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DayResources;
use App\Models\Hari;
use Illuminate\Http\Request;

class DayController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $days = Hari::where('is_aktif', 1)->get();

        return $this->successResponse('Data hari ditemukan', DayResources::collection($days));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
