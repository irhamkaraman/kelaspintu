<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Z0-9\s\-\_\.\(\)]+$/u', // Only alphanumeric, spaces, and safe chars
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kelas wajib diisi',
            'nama.min' => 'Nama kelas minimal 3 karakter',
            'nama.max' => 'Nama kelas maksimal 100 karakter',
            'nama.regex' => 'Nama kelas hanya boleh berisi huruf, angka, spasi, dan karakter (-_.)' ,
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Sanitize inputs
        $this->merge([
            'nama' => strip_tags($this->nama ?? ''),
            'deskripsi' => strip_tags($this->deskripsi ?? ''),
        ]);
    }
}
