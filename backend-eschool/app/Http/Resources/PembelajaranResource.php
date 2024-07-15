<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PembelajaranResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_kelas' => $this->id_kelas,
            'kelas' => $this->kelas->nama,
            'id_guru' => $this->id_guru,
            'guru' => $this->guru->nama,
            'id_mapel' => $this->id_mapel,
            'mapel' => $this->mapel->nama_mapel,
        ];
    }
}
