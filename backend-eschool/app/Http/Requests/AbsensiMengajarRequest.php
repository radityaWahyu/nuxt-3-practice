<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsensiMengajarRequest extends FormRequest
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
            'pembelajaran' => ['required', 'exists:pembelajaran,id'],
            'guru' => ['required', 'exists:pegawai,id'],
            'pembelajaran' => ['required', 'exists:pembelajaran,id'],
            'ruangan' => ['required', 'exists:ruangan,id']
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus diisi',
            'exists' => 'data :attribute tidak ditemukan di sistem'
        ];
    }
}
