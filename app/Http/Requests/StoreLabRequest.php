<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => [
                'required',
                'string',
                'min:3',
                'max:150',
                'regex:/^[a-zA-Z0-9\s\-\_\.\(\)]+$/u',
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'bahasa_pemrograman' => [
                'required',
                'in:Python,JavaScript,PHP,Java',
            ],
            'template_code' => [
                'nullable',
                'string',
                'max:50000', // 50KB code limit
            ],
            'test_cases' => [
                'nullable',
                'json',
                'max:100000', // 100KB JSON limit
            ],
            'deadline' => [
                'nullable',
                'date',
                'after:now',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul lab wajib diisi',
            'judul.min' => 'Judul lab minimal 3 karakter',
            'judul.max' => 'Judul lab maksimal 150 karakter',
            'judul.regex' => 'Judul hanya boleh berisi huruf, angka, spasi, dan karakter (-_.)' ,
            'deskripsi.max' => 'Deskripsi maksimal 2000 karakter',
            'bahasa_pemrograman.required' => 'Bahasa pemrograman wajib dipilih',
            'bahasa_pemrograman.in' => 'Bahasa pemrograman tidak valid',
            'template_code.max' => 'Template code terlalu besar (max 50KB)',
            'test_cases.json' => 'Format test cases harus valid JSON',
            'test_cases.max' => 'Test cases terlalu besar (max 100KB)',
            'deadline.after' => 'Deadline harus setelah waktu sekarang',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'judul' => strip_tags($this->judul ?? ''),
            'deskripsi' => strip_tags($this->deskripsi ?? ''),
            // Don't sanitize template_code as it needs to preserve code syntax
        ]);
    }
}
