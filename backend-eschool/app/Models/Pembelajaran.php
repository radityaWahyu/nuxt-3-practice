<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'pembelajaran';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function mapel()
    {
        return $this->belongsTo(MataPelajaran::class, 'id_mapel', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Pegawai::class, 'id_guru', 'id')->where('jenis_pegawai', 'guru');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester', 'id');
    }

    public function pembelajaran_detail()
    {
        return $this->hasMany(PembelajaranDetail::class, 'id_pembelajaran', 'id');
    }

    public function scopeSemesterAktif($query)
    {
        return $query->whereHas('semester', function ($sql) {
            return $sql->where('is_aktif', 1);
        });
    }
}
