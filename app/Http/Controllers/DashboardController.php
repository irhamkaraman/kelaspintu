<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Keanggotaan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Kelas yang dibuat oleh user
        $kelasDibuat = Kelas::where('pembuat_id', $user->id)
            ->with('tugas')
            ->get();
        
        // Kelas yang diikuti, tapi BUKAN yang dibuat sendiri
        $kelasDigabung = Keanggotaan::where('user_id', $user->id)
            ->whereHas('kelas', function($query) use ($user) {
                $query->where('pembuat_id', '!=', $user->id);
            })
            ->with('kelas.tugas')
            ->get()
            ->pluck('kelas');
        
        return view('dashboard', [
            'kelasDibuat' => $kelasDibuat,
            'kelasDigabung' => $kelasDigabung,
        ]);
    }

    public function search()
    {
        $user = auth()->user();

        // Ambil kelas yang sudah diikuti user
        $kelasDigabungIds = Keanggotaan::where('user_id', $user->id)
            ->pluck('kelas_id')
            ->toArray();

        // Ambil kelas yang dibuat user
        $kelasDibuatIds = Kelas::where('pembuat_id', $user->id)
            ->pluck('id')
            ->toArray();

        // Gabungkan kedua array
        $kelasYangSudahDigabung = array_merge($kelasDigabungIds, $kelasDibuatIds);

        // Ambil kelas yang belum diikuti user dengan pagination (9 per halaman)
        $semuaKelas = Kelas::whereNotIn('id', $kelasYangSudahDigabung)
            ->with(['pembuat', 'tugas', 'anggota'])
            ->paginate(9);

        return view('dashboard-search', [
            'semuaKelas' => $semuaKelas,
            'kelasDigabungIds' => $kelasDigabungIds,
        ]);
    }
}
