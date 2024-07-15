<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'kelas';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function jurusan()
    {
        return $this->belongsTo('App\Jurusan', 'id_jurusan', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'id_guru', 'id');
    }

    public function getAktifAttribute()
    {
        return $this->whereHas('semester', function ($query) {
            return $query->where('is_aktif', 1);
        })->first();
    }

    public function getWalasAktifAttribute()
    {
        return !empty($this->aktif);
    }
}
