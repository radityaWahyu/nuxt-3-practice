<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MataPelajaran extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'mata_pelajaran';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
}
