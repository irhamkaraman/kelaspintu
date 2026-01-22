<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FileSizeRule;
use App\Rules\AllowedFileTypeRule;
use App\Rules\ZipContentRule;
use App\Models\Tugas;

class StorePengumpulanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'tugas_id' => 'required|exists:tugas,id',
            'metode' => 'required|in:upload,link',
        ];

        $tugas = Tugas::find($this->tugas_id);
        
        if ($this->metode === 'upload') {
            $rules['file'] = [
                'required',
                'file',
                new FileSizeRule(10),
                new AllowedFileTypeRule($tugas ? $tugas->jenis_file : []),
            ];
            
            if ($tugas && $tugas->validasi_konten && isset($tugas->validasi_konten['zip'])) {
                $rules['file'][] = new ZipContentRule($tugas->validasi_konten['zip']);
            }
            
        } elseif ($this->metode === 'link') {
            $rules['link_unduhan'] = [
                'required',
                'url',
                'regex:/^https:\/\//',
            ];
            $rules['deskripsi_link'] = 'required|string|min:5|max:1000';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'tugas_id.required' => 'ID tugas wajib diisi',
            'tugas_id.exists' => 'Tugas tidak ditemukan',
            'metode.required' => 'Pilih metode pengumpulan',
            'metode.in' => 'Metode harus upload atau link',
            'file.required' => 'File wajib diunggah',
            'link_unduhan.required' => 'Link unduhan wajib diisi',
            'link_unduhan.url' => 'Link harus berupa URL yang valid',
            'link_unduhan.regex' => 'Link harus menggunakan HTTPS',
            'deskripsi_link.required' => 'Deskripsi link wajib diisi',
            'deskripsi_link.min' => 'Deskripsi minimal 5 karakter',
        ];
    }
}
