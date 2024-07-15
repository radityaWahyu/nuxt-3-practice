<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PembelajaranByUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $detail = $this->pembelajaran_detail->sortBy(function ($q) {
            return $q->jam->nama;
        });
        if ($detail->first()->jam->nama == $detail->last()->jam->nama) {
            $jamPembelajaran = $detail->first()->jam->nama;
        } else {
            $jamPembelajaran = $detail->first()->jam->nama . '-' . $detail->last()->jam->nama;
        }

        return [
            'id' => $this->id,
            'semester_aktif' => $this->semester->nama,
            'kelas' => $this->kelas->nama,
            'mapel' => $this->mapel->nama_mapel,
            'guru' => $this->guru->nama,
            'jam_pelajaran' => $jamPembelajaran,
        ];
    }
}
