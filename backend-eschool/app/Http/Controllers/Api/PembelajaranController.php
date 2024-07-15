<?php

namespace App\Http\Controllers\Api;

use App\Models\Hari;
use App\Models\Semester;
use App\Models\JamPelajaran;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Http\Requests\PembelajaranStoreRequest;
use App\Http\Requests\PembelajaranUpdateRequest;
use App\Http\Resources\PembelajaranByUserResource;
use App\Http\Resources\PembelajaranResource;

class PembelajaranController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $jamPelajaran = JamPelajaran::where('is_aktif', 1)->orderBy('nama', 'asc')->get();
        $hari = Hari::where('is_aktif', 1)->get();

        $jadwal = $jamPelajaran->map(function ($jam, $key) use ($hari, $request) {
            $response = array(
                'id_jam' => $jam->id,
                'kode_jam' => $jam->nama,
                'jam_mulai' => $jam->jam_mulai,
                'jam_berakhir' => $jam->jam_berakhir,
            );

            foreach ($hari as $data) {
                $pembelajaran = Pembelajaran::with(
                    [
                        'guru:id,nama',
                        'kelas:id,nama',
                        'mapel:id,nama_mapel',
                        'pembelajaran_detail'
                    ]
                )
                    ->whereHas('semester', function ($query) {
                        return $query->where('is_aktif', 1);
                    })
                    ->whereHas('pembelajaran_detail', function ($query) use ($jam, $data) {
                        return $query->where('id_hari', $data->id)
                            ->where('id_jam', $jam->id);
                    })
                    ->when(
                        $request->has('kelas'),
                        function ($query) use ($request) {
                            return $query->where('id_kelas', $request->kelas);
                        }
                    )
                    ->when($request->has('guru'), function ($query) use ($request) {
                        return $query->where('id_guru', $request->guru);
                    })
                    ->whereHas('semester', function ($query) {
                        return $query->where('is_aktif', 1);
                    })
                    ->first();

                $response += [$data->nama => empty($pembelajaran) ? null : new PembelajaranResource($pembelajaran)];
            }
            return $response;
        });

        return $this->successResponse('Data pembelajaran di temukan', $jadwal);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PembelajaranStoreRequest $request)
    {
        $semester  = Semester::aktif()->first();

        try {

            $list_pembelajaran = Pembelajaran::with(['pembelajaran_detail'])
                ->whereHas('pembelajaran_detail', function ($query) use ($request) {
                    return $query->where('id_hari', $request->hari)
                        ->where('id_jam', $request->jam);
                })
                ->where('id_guru', $request->guru)
                ->semesterAktif()
                ->first();

            if (!is_null($list_pembelajaran)) {
                $jam = JamPelajaran::find($request->jam);
                $hari = Hari::find($request->hari);
                return $this->successResponse(
                    'Data pembelajaran bentrok dengan kelas lain',
                    [
                        'guru' => $list_pembelajaran->guru->nama,
                        'mapel' => $list_pembelajaran->mapel->nama_mapel,
                        'kelas' => $list_pembelajaran->kelas->nama,
                        'hari' => $hari->nama,
                        'jam_mulai' => $jam->jam_mulai,
                        'jam_berakhir' => $jam->jam_berakhir,
                    ]
                );
            }


            $pembelajaran = Pembelajaran::create(
                [
                    'id_mapel' => $request->mapel,
                    'id_guru' => $request->guru,
                    'id_semester' => $semester->id,
                    'id_kelas' => $request->kelas,
                ]
            );

            $pembelajaran->pembelajaran_detail()->create(
                [
                    'id_jam' => $request->jam,
                    'id_hari' => $request->hari
                ]
            );

            return $this->successResponse('Data pembelajaran berhasil di tambahkan');
        } catch (\Exception $e) {
            return $this->errorServerResponse($e->getMessage());
        }
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
    public function update(PembelajaranStoreRequest $request, Pembelajaran $pembelajaran)
    {
        try {
            $list_pembelajaran = Pembelajaran::with('pembelajaran_detail', 'guru', 'mapel', 'kelas')
                ->whereHas('pembelajaran_detail', function ($query) use ($request) {
                    return $query->where('id_hari', $request->hari)
                        ->where('id_jam', $request->hari);
                })
                ->where('id_guru', $request->guru)
                ->semesterAktif()
                ->first();


            $jam = JamPelajaran::find($list_pembelajaran->pembelajaran_detail->id_jam);
            $hari = Hari::find($list_pembelajaran->pembelajaran_detail->id_hari);

            if ($list_pembelajaran->id_guru !== $request->guru && $list_pembelajaran->id_mapel !== $request->mapel) {
                return $this->successResponse(
                    'Data pembelajaran bentrok dengan kelas lain',
                    [
                        'guru' => $list_pembelajaran->guru->nama,
                        'mapel' => $list_pembelajaran->mapel->nama_mapel,
                        'kelas' => $list_pembelajaran->kelas->nama,
                        'hari' => $hari->nama,
                        'jam_mulai' => $jam->jam_mulai,
                        'jam_berakhir' => $jam->jam_berakhir,
                    ]
                );
            }


            if (is_null($list_pembelajaran)) {
                $pembelajaran->id_mapel = $request->mapel;
                $pembelajaran->id_guru = $request->guru;
                $pembelajaran->save();
            }

            return $this->successResponse('Data pembelajaran berhasil di update');
        } catch (\Exception $e) {
            return $this->errorServerResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembelajaran $pembelajaran)
    {
        try {
            $pembelajaran->delete();

            return $this->successResponse('Data pembelajaran berhasil di hapus');
        } catch (\Exception $e) {
            return $this->errorServerResponse($e->getMessage());
        }
    }

    public function pembelajaranByUser(Request $request)
    {
        $pembelajaran = Pembelajaran::query();

        if ($request->has('hari')) {
            $pembelajaran = $pembelajaran->withWhereHas('pembelajaran_detail', function ($query) use ($request) {
                return $query->whereHas('hari', function ($q) use ($request) {
                    return $q->where('nama', $request->hari);
                });
            });

            $pembelajaran = $pembelajaran->where('id_guru', $request->user()->userable->id)
                ->SemesterAktif()
                ->get();
            return $this->successResponse('Pembelajaran berhasil di temukan', PembelajaranByUserResource::collection($pembelajaran));
        }
    }
}
