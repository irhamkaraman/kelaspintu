<?php

namespace App\Http\Controllers;

use App\Models\SubModul;
use App\Models\Modul;
use App\Models\ProgressModul;
use App\Models\Keanggotaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubModulController extends Controller
{
    public function create($modulId)
    {
        $modul = Modul::with('kelas')->findOrFail($modulId);
        
        // Only instruktur can create
        Keanggotaan::where('kelas_id', $modul->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->firstOrFail();

        return view('sub-modul.create', compact('modul'));
    }

    public function store(Request $request, $modulId)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'konten' => 'required|string',
            'estimasi_menit' => 'nullable|integer|min:1|max:999',
            'file' => 'nullable|file|mimes:pdf,ppt,pptx|max:20480',
            'link_eksternal' => 'nullable|url'
        ]);

        // Get max urutan
        $maxUrutan = SubModul::where('modul_id', $modulId)->max('urutan') ?? 0;

        $data = [
            'modul_id' => $modulId,
            'judul' => $request->judul,
            'konten' => $request->konten,
            'urutan' => $maxUrutan + 1,
            'estimasi_menit' => $request->estimasi_menit,
            'link_eksternal' => $request->link_eksternal
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            $subModul = new SubModul();
            $data['file_path'] = $subModul->simpanFile($request->file('file'));
            $data['file_name'] = $request->file('file')->getClientOriginalName();
        }

        SubModul::create($data);

        return redirect()->route('modul.show', $modulId)
            ->with('success', 'Sub-modul berhasil dibuat!');
    }

    public function show($subModulId)
    {
        $subModul = SubModul::with(['modul.kelas', 'modul.subModul'])->findOrFail($subModulId);
        
        // Check membership
        $keanggotaan = Keanggotaan::where('kelas_id', $subModul->modul->kelas_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Get navigation
        $nextSubModul = $subModul->getNextSubModul();
        $previousSubModul = $subModul->getPreviousSubModul();

        // Check if completed
        $isSelesai = $subModul->isSelesaiBy(auth()->id());

        return view('sub-modul.show', compact('subModul', 'keanggotaan', 'nextSubModul', 'previousSubModul', 'isSelesai'));
    }

    public function edit($subModulId)
    {
        $subModul = SubModul::with('modul.kelas')->findOrFail($subModulId);
        
        // Only instruktur can edit
        Keanggotaan::where('kelas_id', $subModul->modul->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->firstOrFail();

        return view('sub-modul.edit', compact('subModul'));
    }

    public function update(Request $request, $subModulId)
    {
        $subModul = SubModul::findOrFail($subModulId);
        
        $request->validate([
            'judul' => 'required|string|max:200',
            'konten' => 'required|string',
            'estimasi_menit' => 'nullable|integer|min:1|max:999',
            'file' => 'nullable|file|mimes:pdf,ppt,pptx|max:20480',
            'link_eksternal' => 'nullable|url'
        ]);

        $data = $request->only(['judul', 'konten', 'estimasi_menit', 'link_eksternal']);

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            $subModul->hapusFile();
            
            // Upload new file
            $data['file_path'] = $subModul->simpanFile($request->file('file'));
            $data['file_name'] = $request->file('file')->getClientOriginalName();
        }

        $subModul->update($data);

        return redirect()->route('sub-modul.show', $subModulId)
            ->with('success', 'Sub-modul berhasil diupdate!');
    }

    public function destroy($subModulId)
    {
        $subModul = SubModul::findOrFail($subModulId);
        $modulId = $subModul->modul_id;
        
        // Only instruktur can delete
        Keanggotaan::where('kelas_id', $subModul->modul->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->firstOrFail();

        // Delete file
        $subModul->hapusFile();
        
        $subModul->delete();

        return redirect()->route('modul.show', $modulId)
            ->with('success', 'Sub-modul berhasil dihapus!');
    }

    public function markComplete($subModulId)
    {
        $subModul = SubModul::findOrFail($subModulId);
        
        // Check membership
        Keanggotaan::where('kelas_id', $subModul->modul->kelas_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Toggle completion
        $progress = ProgressModul::where('user_id', auth()->id())
            ->where('sub_modul_id', $subModulId)
            ->first();

        if ($progress) {
            $progress->update([
                'selesai' => !$progress->selesai,
                'waktu_selesai' => !$progress->selesai ? now() : null
            ]);
        } else {
            ProgressModul::create([
                'user_id' => auth()->id(),
                'sub_modul_id' => $subModulId,
                'selesai' => true,
                'waktu_selesai' => now()
            ]);
        }

        return back()->with('success', 'Progress berhasil diupdate!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120' // 5MB
        ]);

        $image = $request->file('image');
        $filename = time() . '_' . $image->getClientOriginalName();
        $path = $image->storeAs('modul-images', $filename, 'public');

        return response()->json([
            'success' => true,
            'url' => Storage::url($path)
        ]);
    }
}
