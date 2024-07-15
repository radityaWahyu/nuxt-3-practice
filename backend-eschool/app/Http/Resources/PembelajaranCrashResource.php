<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PembelajaranCrashResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'guru' => $this->guru->nama,
            'mapel' => $this->mapel->nama,
            'jam_mulai' => $this->pembelajaran_detail->jam->jam_mulai,
            'jam_berakhir' => $this->jam->jam_berakhir,
        ];
    }
}
