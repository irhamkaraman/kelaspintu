<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Keanggotaan;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\JoinKelasRequest;

class KelasController extends Controller
{
    public function create()
    {
        return view('kelas.create');
    }

    public function store(StoreKelasRequest $request)
    {
        $kelas = Kelas::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'pembuat_id' => auth()->id(),
        ]);

        Keanggotaan::create([
            'kelas_id' => $kelas->id,
            'user_id' => auth()->id(),
            'sebagai' => 'instruktur',
        ]);

        return redirect()->route('kelas.show', $kelas->kode_unik)
            ->with('success', "Kelas berhasil dibuat! Kode kelas: {$kelas->kode_unik}");
    }

    public function show($kodeUnik)
    {
        $kelas = Kelas::where('kode_unik', $kodeUnik)
            ->with(['tugas', 'labSessions', 'anggota.user'])
            ->firstOrFail();

        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$keanggotaan && $kelas->pembuat_id !== auth()->id()) {
            abort(403, 'Anda bukan anggota kelas ini.');
        }

        $isInstruktur = $keanggotaan && $keanggotaan->sebagai === 'instruktur';

        return view('kelas.show', [
            'kelas' => $kelas,
            'isInstruktur' => $isInstruktur,
        ]);
    }

    public function join()
    {
        return view('kelas.join');
    }

    public function storeJoin(JoinKelasRequest $request)
    {
        $kelas = Kelas::where('kode_unik', $request->kode_unik)->firstOrFail();

        $sudahGabung = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($sudahGabung) {
            return back()->with('error', 'Anda sudah menjadi anggota kelas ini.');
        }

        Keanggotaan::create([
            'kelas_id' => $kelas->id,
            'user_id' => auth()->id(),
            'sebagai' => 'mahasiswa',
        ]);

        return redirect()->route('kelas.show', $kelas->kode_unik)
            ->with('success', 'Berhasil bergabung ke kelas!');
    }

    public function edit($kodeUnik)
    {
        $kelas = Kelas::where('kode_unik', $kodeUnik)->firstOrFail();

        // Only instructor can edit
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat mengedit kelas.');
        }

        return view('kelas.edit', ['kelas' => $kelas]);
    }

    public function update(StoreKelasRequest $request, $kodeUnik)
    {
        $kelas = Kelas::where('kode_unik', $kodeUnik)->firstOrFail();

        // Only instructor can update
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat mengupdate kelas.');
        }

        $kelas->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kelas.show', $kelas->kode_unik)
            ->with('success', 'Kelas berhasil diupdate!');
    }

    public function members($kodeUnik)
    {
        $kelas = Kelas::where('kode_unik', $kodeUnik)
            ->with(['anggota.user'])
            ->firstOrFail();

        // Only instructor can manage members
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat mengelola anggota.');
        }

        return view('kelas.members', ['kelas' => $kelas]);
    }

    public function removeMember($kodeUnik, $userId)
    {
        $kelas = Kelas::where('kode_unik', $kodeUnik)->firstOrFail();

        // Check if user is instructor
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        // User dapat menghapus dirinya sendiri, atau instruktur dapat menghapus anggota lain
        if (auth()->id() !== (int)$userId && !$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat menghapus anggota.');
        }

        // Cannot remove instructor themselves
        $targetKeanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', $userId)
            ->where('sebagai', 'instruktur')
            ->first();

        if ($targetKeanggotaan && auth()->id() !== (int)$userId) {
            return back()->with('error', 'Tidak dapat menghapus instruktur dari kelas.');
        }

        Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', $userId)
            ->delete();

        $message = auth()->id() === (int)$userId 
            ? 'Anda berhasil keluar dari kelas.' 
            : 'Anggota berhasil dihapus dari kelas.';

        return redirect()->route('dashboard')->with('success', $message);
    }

    public function destroy($kodeUnik)
    {
        $kelas = Kelas::where('kode_unik', $kodeUnik)->firstOrFail();
        
        // Check if user is instructor (same pattern as TugasController and LabController)
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat menghapus kelas.');
        }
        
        // Delete class (cascade will delete all related data)
        $kelas->delete();
        
        return redirect()->route('dashboard')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}
