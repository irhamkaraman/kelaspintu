<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengumpulan;
use App\Models\Tugas;
use App\Models\Keanggotaan;
use App\Http\Requests\StorePengumpulanRequest;
use App\Http\Requests\UpdateNilaiRequest;

class PengumpulanController extends Controller
{
    public function create($tugasId)
    {
        $tugas = Tugas::with('kelas')->findOrFail($tugasId);
        
        $keanggotaan = Keanggotaan::where('kelas_id', $tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$keanggotaan || $keanggotaan->sebagai !== 'mahasiswa') {
            abort(403, 'Hanya mahasiswa yang dapat mengumpulkan tugas.');
        }

        $pengumpulan = Pengumpulan::where('tugas_id', $tugasId)
            ->where('user_id', auth()->id())
            ->first();

        if ($pengumpulan && $pengumpulan->status !== 'revisi') {
            return back()->with('error', 'Anda sudah mengumpulkan tugas ini. Tunggu penilaian dari instruktur.');
        }

        return view('pengumpulan.create', [
            'tugas' => $tugas,
            'pengumpulan' => $pengumpulan,
        ]);
    }

    public function store(StorePengumpulanRequest $request)
    {
        $tugas = Tugas::with('kelas')->findOrFail($request->tugas_id);
        
        // Validasi bahwa user adalah mahasiswa di kelas ini
        $keanggotaan = Keanggotaan::where('kelas_id', $tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$keanggotaan || $keanggotaan->sebagai !== 'mahasiswa') {
            abort(403, 'Hanya mahasiswa yang dapat mengumpulkan tugas.');
        }
        
        $pengumpulanLama = Pengumpulan::where('tugas_id', $request->tugas_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($pengumpulanLama && $pengumpulanLama->status !== 'revisi') {
            return back()->with('error', 'Anda sudah mengumpulkan tugas ini.');
        }

        $data = [
            'tugas_id' => $request->tugas_id,
            'user_id' => auth()->id(),
            'status' => 'baru',
        ];

        if ($request->metode === 'upload') {
            if ($pengumpulanLama) {
                $pengumpulanLama->hapusFile();
            }
            
            $pengumpulan = new Pengumpulan();
            $filePath = $pengumpulan->simpanFile($request->file('file'), $tugas->id, auth()->id());
            
            $data['file_path'] = $filePath;
            $data['link_unduhan'] = null;
            $data['deskripsi_link'] = null;
            
        } elseif ($request->metode === 'link') {
            if ($pengumpulanLama) {
                $pengumpulanLama->hapusFile();
            }
            
            $data['file_path'] = null;
            $data['link_unduhan'] = $request->link_unduhan;
            $data['deskripsi_link'] = $request->deskripsi_link;
        }

        if ($pengumpulanLama) {
            $pengumpulanLama->update($data);
            $message = 'Tugas berhasil dikumpulkan ulang!';
        } else {
            Pengumpulan::create($data);
            $message = 'Tugas berhasil dikumpulkan!';
        }

        return redirect()->route('tugas.show', $tugas->id)
            ->with('success', $message);
    }

    public function update(UpdateNilaiRequest $request, $id)
    {
        $pengumpulan = Pengumpulan::with('tugas.kelas')->findOrFail($id);
        
        $keanggotaan = Keanggotaan::where('kelas_id', $pengumpulan->tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat memberikan nilai.');
        }

        $pengumpulan->update([
            'nilai' => $request->nilai,
            'feedback' => $request->feedback,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Penilaian berhasil disimpan!');
    }

    public function download($id)
    {
        $pengumpulan = Pengumpulan::findOrFail($id);
        
        $tugas = $pengumpulan->tugas;
        $keanggotaan = Keanggotaan::where('kelas_id', $tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$keanggotaan && $pengumpulan->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh file ini.');
        }

        if (!$pengumpulan->file_path || !Storage::disk('local')->exists($pengumpulan->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('local')->download($pengumpulan->file_path);
    }
}
