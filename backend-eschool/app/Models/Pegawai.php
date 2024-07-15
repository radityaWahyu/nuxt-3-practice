<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = "id";
    protected $table = 'pegawai';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id_guru', 'id');
    }
}
