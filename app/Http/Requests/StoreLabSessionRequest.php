<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bahasa_pemrograman' => 'required|in:c,cpp,java,python,php,javascript',
            'template_code' => 'nullable|string',
            'test_cases' => 'nullable|json',
            'deadline' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'kelas_id.required' => 'Kelas harus dipilih',
            'kelas_id.exists' => 'Kelas tidak ditemukan',
            'judul.required' => 'Judul lab harus diisi',
            'bahasa_pemrograman.required' => 'Bahasa pemrograman harus dipilih',
            'bahasa_pemrograman.in' => 'Bahasa pemrograman tidak valid',
            'test_cases.json' => 'Format test cases harus JSON yang valid',
        ];
    }
}
