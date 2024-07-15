<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelperController extends ApiBaseController
{
    public function getTanggal()
    {
        $today = Carbon::now()->locale('id');
        $today->settings(['formatFunction' => 'translatedFormat']);
        $fullDate = strtolower($today->format('l, d F Y'));

        return $this->successResponse('tanggal sekarang', Str::title($fullDate));
    }
}
