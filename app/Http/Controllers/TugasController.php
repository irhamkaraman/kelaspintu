<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\Keanggotaan;
use App\Http\Requests\StoreTugasRequest;

class TugasController extends Controller
{
    public function create($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat membuat tugas.');
        }

        return view('tugas.create', ['kelas' => $kelas]);
    }

    public function store(StoreTugasRequest $request)
    {
        $kelas = Kelas::findOrFail($request->kelas_id);
        
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat membuat tugas.');
        }

        $validasiKonten = null;
        if ($request->validasi_konten) {
            $validasiKonten = json_decode($request->validasi_konten, true);
        }

        $tugas = Tugas::create([
            'kelas_id' => $request->kelas_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'jenis_file' => $request->jenis_file,
            'ukuran_maks_mb' => $request->ukuran_maks_mb,
            'validasi_konten' => $validasiKonten,
        ]);

        return redirect()->route('kelas.show', $kelas->kode_unik)
            ->with('success', 'Tugas berhasil dibuat!');
    }

    public function show($id)
    {
        $tugas = Tugas::with('kelas')->findOrFail($id);
        
        $keanggotaan = Keanggotaan::where('kelas_id', $tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Anda bukan anggota kelas ini.');
        }

        $isInstruktur = $keanggotaan->sebagai === 'instruktur';
        $pengumpulan = $tugas->sudahDikumpulkan(auth()->id());

        return view('tugas.show', [
            'tugas' => $tugas,
            'isInstruktur' => $isInstruktur,
            'pengumpulan' => $pengumpulan,
        ]);
    }

    public function nilai($id)
    {
        $tugas = Tugas::with(['kelas', 'pengumpulan.mahasiswa'])->findOrFail($id);
        
        $keanggotaan = Keanggotaan::where('kelas_id', $tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat melihat halaman ini.');
        }

        return view('tugas.nilai', [
            'tugas' => $tugas,
            'pengumpulanList' => $tugas->pengumpulan,
        ]);
    }

    public function edit($id)
    {
        $tugas = Tugas::with('kelas')->findOrFail($id);
        
        $keanggotaan = Keanggotaan::where('kelas_id', $tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat mengedit tugas.');
        }

        return view('tugas.edit', ['tugas' => $tugas]);
    }

    public function update(StoreTugasRequest $request, $id)
    {
        $tugas = Tugas::findOrFail($id);
        
        $keanggotaan = Keanggotaan::where('kelas_id', $tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat mengupdate tugas.');
        }

        $validasiKonten = null;
        if ($request->validasi_konten) {
            $validasiKonten = json_decode($request->validasi_konten, true);
        }

        $tugas->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
            'jenis_file' => $request->jenis_file,
            'ukuran_maks_mb' => $request->ukuran_maks_mb,
            'validasi_konten' => $validasiKonten,
        ]);

        return redirect()->route('tugas.show', $tugas->id)
            ->with('success', 'Tugas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);
        
        // Check authorization - only instructor can delete
        $keanggotaan = Keanggotaan::where('kelas_id', $tugas->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat menghapus tugas.');
        }
        
        $kelasKode = $tugas->kelas->kode_unik;
        $tugas->delete();
        
        return redirect()->route('kelas.show', $kelasKode)
            ->with('success', 'Tugas berhasil dihapus!');
    }
}
