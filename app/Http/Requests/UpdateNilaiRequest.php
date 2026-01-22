<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nilai' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string|max:2000',
            'status' => 'required|in:baru,dicek,revisi,lulus',
        ];
    }

    public function messages(): array
    {
        return [
            'nilai.required' => 'Nilai wajib diisi',
            'nilai.integer' => 'Nilai harus berupa angka',
            'nilai.min' => 'Nilai minimal 0',
            'nilai.max' => 'Nilai maksimal 100',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ];
    }
}
