<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kode_unik' => 'required|string|size:6|exists:kelas,kode_unik',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_unik.required' => 'Kode kelas wajib diisi',
            'kode_unik.size' => 'Kode kelas harus 6 karakter',
            'kode_unik.exists' => 'Kode kelas tidak ditemukan',
        ];
    }
}
