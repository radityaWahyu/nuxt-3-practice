<?php

namespace App\Http\Controllers\Api;



// use Carbon\Carbon;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Models\AbsensiMengajar;
use App\Http\Requests\AbsensiMengajarRequest;
use App\Http\Controllers\Api\ApiBaseController;
use Nette\Schema\Helpers;

class AbsensiMengajarController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AbsensiMengajarRequest $request)
    {
        $dayNow = $this->cekHari();

        $pembelajaran = Pembelajaran::query()
            ->where('id', $request->pembelajaran)
            ->whereHas('pembelajaran_detail', function ($query) use ($dayNow) {
                return $query->whereHas('hari', function ($q) use ($dayNow) {
                    return $q->where('nama', $dayNow);
                });
            })
            ->first();

        if (is_null($pembelajaran)) {
            return $this->notFoundResponse('Mapel tidak terjadwal pada hari ini');
        }

        $absensiMengajar = AbsensiMengajar::create([
            'id_guru' => $request->guru, //$request->auth()->userable->id,
            'id_pembelajaran' => $request->pembelajaran,
            'id_ruangan' => $request->ruangan,
            'materi' => $request->materi,
            'status' => 'masuk'
        ]);

        return $this->successResponse('Guru telah berhasil absensi');
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
