<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{

    private $token;

    public function __construct($resource, $token)
    {
        parent::__construct($resource);
        $this->resource = $resource;

        $this->token = $token;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $modelType = explode('\\', $this->userable_type);
        if ($modelType[2] == 'Siswa') {
            $role = ['siswa'];
        } else {
            if ($this->userable->jenis_pegawai == 'guru') {
                if ($this->userable->kelas->walas_aktif) {
                    $role = ['walas'];
                }
            } else {
                $role = ['tu'];
            }

            $roles = collect($role)->merge($this->getRoleNames());
        }


        return [
            'username' => $this->username,
            'id' => $this->userable->id,
            'nama' => $this->userable->nama,
            'role' => $roles,
            'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
            'token' => $this->token
        ];
    }
}
