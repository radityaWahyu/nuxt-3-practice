<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembelajaranUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mapel' => ['required', 'exists:mata_pelajaran,id'],
            'guru' => ['required', 'exists:pegawai,id']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute harus diisi',
            'exists' => 'data :attribute tidak terdaftar dalam sistem'
        ];
    }
}
