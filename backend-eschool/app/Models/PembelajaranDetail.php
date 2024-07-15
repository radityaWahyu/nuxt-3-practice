<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelajaranDetail extends Model
{
    use HasFactory;

    protected $table = 'pembelajaran_detail';
    protected $guarded = [];

    public function jam()
    {
        return $this->belongsTo(JamPelajaran::class, 'id_jam', 'id');
    }

    public function hari()
    {
        return $this->belongsTo(Hari::class, 'id_hari', 'id');
    }
}
