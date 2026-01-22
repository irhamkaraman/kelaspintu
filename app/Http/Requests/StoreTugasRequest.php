<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTugasRequest extends FormRequest
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
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
            'deadline' => [
                'required',
                'date',
                'after:now',
            ],
            'file' => [
                'nullable',
                'file',
                'max:10240', // 10MB
                'mimes:pdf,doc,docx,txt,zip',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul tugas wajib diisi',
            'judul.min' => 'Judul tugas minimal 3 karakter',
            'judul.max' => 'Judul tugas maksimal 150 karakter',
            'judul.regex' => 'Judul hanya boleh berisi huruf, angka, spasi, dan karakter (-_.)' ,
            'deskripsi.required' => 'Deskripsi tugas wajib diisi',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 2000 karakter',
            'deadline.required' => 'Deadline wajib diisi',
            'deadline.after' => 'Deadline harus setelah waktu sekarang',
            'file.max' => 'Ukuran file maksimal 10MB',
            'file.mimes' => 'File harus berformat: pdf, doc, docx, txt, atau zip',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'judul' => strip_tags($this->judul ?? ''),
            'deskripsi' => strip_tags($this->deskripsi ?? ''),
        ]);
    }
}
