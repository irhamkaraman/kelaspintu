<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Modul;
use App\Models\Keanggotaan;
use Illuminate\Http\Request;

class ModulController extends Controller
{
    public function index($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        
        // Check membership
        $keanggotaan = Keanggotaan::where('kelas_id', $kelasId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Anda bukan anggota kelas ini.');
        }

        $moduls = Modul::where('kelas_id', $kelasId)
            ->orderBy('urutan')
            ->get();

        // Add progress for each modul
        foreach ($moduls as $modul) {
            $modul->progress_count = $modul->progressUser(auth()->id());
            $modul->total_count = $modul->totalSubModul();
            $modul->persentase = $modul->persentaseProgress(auth()->id());
        }

        return view('modul.index', compact('kelas', 'moduls', 'keanggotaan'));
    }

    public function create($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        
        // Only instruktur can create
        $keanggotaan = Keanggotaan::where('kelas_id', $kelasId)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->firstOrFail();

        return view('modul.create', compact('kelas'));
    }

    public function store(Request $request, $kelasId)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,published'
        ]);

        // Get max urutan
        $maxUrutan = Modul::where('kelas_id', $kelasId)->max('urutan') ?? 0;

        Modul::create([
            'kelas_id' => $kelasId,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'urutan' => $maxUrutan + 1,
            'status' => $request->status
        ]);

        return redirect()->route('modul.index', $kelasId)
            ->with('success', 'Modul berhasil dibuat!');
    }

    public function show($modulId)
    {
        $modul = Modul::with(['subModul', 'kelas'])->findOrFail($modulId);
        
        // Check membership
        $keanggotaan = Keanggotaan::where('kelas_id', $modul->kelas_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Add progress for each sub-modul
        foreach ($modul->subModul as $sub) {
            $sub->is_selesai = $sub->isSelesaiBy(auth()->id());
        }

        return view('modul.show', compact('modul', 'keanggotaan'));
    }

    public function edit($modulId)
    {
        $modul = Modul::with('kelas')->findOrFail($modulId);
        
        // Only instruktur can edit
        Keanggotaan::where('kelas_id', $modul->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->firstOrFail();

        return view('modul.edit', compact('modul'));
    }

    public function update(Request $request, $modulId)
    {
        $modul = Modul::findOrFail($modulId);
        
        $request->validate([
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'required|in:draft,published'
        ]);

        $modul->update($request->only(['judul', 'deskripsi', 'status']));

        return redirect()->route('modul.show', $modulId)
            ->with('success', 'Modul berhasil diupdate!');
    }

    public function destroy($modulId)
    {
        $modul = Modul::findOrFail($modulId);
        $kelasId = $modul->kelas_id;
        
        // Only instruktur can delete
        Keanggotaan::where('kelas_id', $kelasId)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->firstOrFail();

        $modul->delete();

        return redirect()->route('modul.index', $kelasId)
            ->with('success', 'Modul berhasil dihapus!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'moduls' => 'required|array',
            'moduls.*.id' => 'required|exists:modul,id',
            'moduls.*.urutan' => 'required|integer'
        ]);

        foreach ($request->moduls as $item) {
            Modul::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['success' => true]);
    }
}
