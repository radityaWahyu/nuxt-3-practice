<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Http\Requests\JurusanRequest;
use App\Traits\ApiResponse;

class JurusanController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $jurusan = Jurusan::paginate(5);
        // $user = auth()->user();
        // return $user;

        return $this->successCollectionResponse('Data Jurusan Ditemukan', $jurusan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JurusanRequest $request)
    {
        try {

            Jurusan::create($request->validated());

            return $this->successResponse('Jurusan berhasil disimpan', $request->validated());
        } catch (\Exception $error) {
            return $this->errorServerResponse($error);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        try {
            return $this->successResponse('Jurusan ditemukan', $jurusan);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $error) {
            return $this->notFoundResponse($error);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JurusanRequest $request, Jurusan $jurusan)
    {
        try {
            $jurusan->update($request->validated());
        } catch (\Exception $error) {
            return $this->errorServerResponse($error);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
