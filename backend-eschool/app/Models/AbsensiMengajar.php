<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiMengajar extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'absensi_mengajar';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function pembelajaran()
    {
        return $this->belongsTo('App\Pembelajaran', 'id_pembelajaran', 'id');
    }

    public function ruangan()
    {
        return $this->belongsTo('App\Ruangan', 'id_ruangan', 'id');
    }
}
