<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'siswa';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function jurusan()
    {
        return $this->belongsTo('App\Jurusan', 'id_jurusan', 'id');
    }
}
