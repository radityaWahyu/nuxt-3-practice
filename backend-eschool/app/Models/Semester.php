<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';
    protected $guarded = [];

    protected $cast = [
        'is_aktif' => 'boolean'
    ];


    public function getAktifAttribute()
    {
        return $this->where('is_aktif', 0)->first();
    }

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', 1);
    }
}
