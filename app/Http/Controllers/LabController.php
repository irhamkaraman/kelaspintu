<?php

namespace App\Http\Controllers;

use App\Models\LabSession;
use App\Models\LabSubmission;
use App\Models\Kelas;
use App\Models\Keanggotaan;
use App\Services\PistonService;
use App\Http\Requests\StoreLabSessionRequest;
use Illuminate\Http\Request;

class LabController extends Controller
{
    protected $executor;

    public function __construct(PistonService $executor)
    {
        $this->executor = $executor;
    }

    // ... (index, create, store methods remain unchanged) ...

    /**
     * Display all lab sessions for authenticated user
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get all kelas where user is member
        $kelasIds = Keanggotaan::where('user_id', $user->id)
            ->pluck('kelas_id');
        
        // Get kelas where user is instructor (created by them)
        $kelasInstruktor = Keanggotaan::where('user_id', $user->id)
            ->where('sebagai', 'instruktur')
            ->pluck('kelas_id');
        
        // Labs from classes where user is instructor (created labs)
        $createdLabs = LabSession::with(['kelas', 'submissions' => function($query) use ($user) {
                $query->where('user_id', $user->id)->latest();
            }])
            ->whereIn('kelas_id', $kelasInstruktor)
            ->orderBy('deadline', 'desc')
            ->get();
        
        // Labs from classes where user is mahasiswa (joined labs)
        $joinedLabs = LabSession::with(['kelas', 'submissions' => function($query) use ($user) {
                $query->where('user_id', $user->id)->latest();
            }])
            ->whereIn('kelas_id', $kelasIds)
            ->whereNotIn('kelas_id', $kelasInstruktor)
            ->orderBy('deadline', 'desc')
            ->get();
        
        return view('lab.index', compact('createdLabs', 'joinedLabs'));
    }

    /**
     * Show form to create new lab session
     */
    public function create($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        
        // Check if user is instructor
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat membuat lab session.');
        }

        return view('lab.create', compact('kelas'));
    }

    /**
     * Store new lab session
     */
    public function store(StoreLabSessionRequest $request)
    {
        $kelas = Kelas::findOrFail($request->kelas_id);
        
        // Check authorization
        $keanggotaan = Keanggotaan::where('kelas_id', $kelas->id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat membuat lab session.');
        }

        // Parse test cases if provided
        $testCases = null;
        if ($request->test_cases) {
            $testCases = json_decode($request->test_cases, true);
        }

        $lab = LabSession::create([
            'kelas_id' => $request->kelas_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bahasa_pemrograman' => $request->bahasa_pemrograman,
            'template_code' => $request->template_code,
            'test_cases' => $testCases,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('lab.show', $lab->id)
            ->with('success', 'Lab session berhasil dibuat!');
    }

    /**
     * Show lab session dengan code editor
     */
    public function show($id)
    {
        $lab = LabSession::with('kelas')->findOrFail($id);
        
        // Check if user is member
        $keanggotaan = Keanggotaan::where('kelas_id', $lab->kelas_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Anda bukan anggota kelas ini.');
        }

        $isInstruktur = $keanggotaan->sebagai === 'instruktur';
        
        // Get user's last submission
        $lastSubmission = $lab->getUserSubmission(auth()->id());

        return view('lab.show', compact('lab', 'isInstruktur', 'lastSubmission'));
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $lab = LabSession::with('kelas')->findOrFail($id);
        
        // Check authorization
        $keanggotaan = Keanggotaan::where('kelas_id', $lab->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat mengedit lab session.');
        }

        return view('lab.edit', compact('lab'));
    }

    /**
     * Update lab session
     */
    public function update(StoreLabSessionRequest $request, $id)
    {
        $lab = LabSession::findOrFail($id);
        
        // Check authorization
        $keanggotaan = Keanggotaan::where('kelas_id', $lab->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat mengupdate lab session.');
        }

        $testCases = null;
        if ($request->test_cases) {
            $testCases = json_decode($request->test_cases, true);
        }

        $lab->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bahasa_pemrograman' => $request->bahasa_pemrograman,
            'template_code' => $request->template_code,
            'test_cases' => $testCases,
            'deadline' => $request->deadline,
        ]);

        return redirect()->route('lab.show', $lab->id)
            ->with('success', 'Lab session berhasil diupdate!');
    }

    /**
     * Submit code untuk dieksekusi
     */
    public function submit(Request $request, $id)
    {
        $request->validate([
            'source_code' => 'required|string',
        ]);

        $lab = LabSession::findOrFail($id);

        // Check if user is member
        $keanggotaan = Keanggotaan::where('kelas_id', $lab->kelas_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$keanggotaan) {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan anggota kelas ini.',
            ], 403);
        }

        try {
            // Get test cases
            $stdin = $lab->test_cases['input'] ?? null;
            $expectedOutput = $lab->test_cases['expected_output'] ?? null;

            // Submit to Piston Service
            $result = $this->executor->executeCode(
                $request->source_code,
                $lab->bahasa_pemrograman,
                $stdin
            );

            // Output from Piston
            $output = $result['run']['output'] ?? '';
            $stderr = $result['run']['stderr'] ?? '';
            $exitCode = $result['run']['code'] ?? 0;

            // Determine status & score
            $status = 'failed';
            $score = 0;
            
            // Perbandingan output (trim whitespace untuk akurasi)
            if ($exitCode === 0) {
                if ($expectedOutput) {
                    if (trim($output) === trim($expectedOutput)) {
                        $status = 'passed';
                        $score = 100;
                    } else {
                        $status = 'failed';
                        $score = 0;
                    }
                } else {
                    // Jika tidak ada expected output tapi run success, anggap passed
                    $status = 'passed';
                    $score = 100;
                }
            } else {
                $status = 'error';
            }

            // Save or Update submission
            $submission = LabSubmission::updateOrCreate(
                [
                    'lab_session_id' => $id,
                    'user_id' => auth()->id(),
                ],
                [
                    'source_code' => $request->source_code,
                    'language' => $lab->bahasa_pemrograman,
                    'status' => $status,
                    'output' => $output,
                    'error_message' => $stderr,
                    'execution_time' => 0,
                    'memory_used' => 0,
                    'score' => $score,
                    'test_results' => $result,
                ]
            );

            return response()->json([
                'success' => true,
                'submission' => $submission,
                'output' => $output,
                'error' => $stderr,
                'status' => $status,
                'score' => $score,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Execution failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete submission (reset)
     */
    public function destroySubmission($id)
    {
        $submission = LabSubmission::findOrFail($id);
        $lab = $submission->labSession;

        // Check authorization: Only instructor of the class can delete
        $keanggotaan = Keanggotaan::where('kelas_id', $lab->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat menghapus submission.');
        }

        $submission->delete();

        return back()->with('success', 'Submission berhasil dihapus.');
    }

    /**
     * View all submissions (instruktur only)
     */
    public function submissions($id)
    {
        $lab = LabSession::with(['kelas', 'submissions.mahasiswa'])->findOrFail($id);
        
        // Check authorization
        $keanggotaan = Keanggotaan::where('kelas_id', $lab->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat melihat submissions.');
        }

        $submissions = $lab->submissions()->with('mahasiswa')->latest()->get();

        return view('lab.submissions', compact('lab', 'submissions'));
    }

    public function destroy($id)
    {
        $lab = LabSession::findOrFail($id);
        
        // Check authorization - only instructor can delete
        $keanggotaan = Keanggotaan::where('kelas_id', $lab->kelas_id)
            ->where('user_id', auth()->id())
            ->where('sebagai', 'instruktur')
            ->first();

        if (!$keanggotaan) {
            abort(403, 'Hanya instruktur yang dapat menghapus lab session.');
        }
        
        $kelasKode = $lab->kelas->kode_unik;
        $lab->delete();
        
        return redirect()->route('kelas.show', $kelasKode)
            ->with('success', 'Lab session berhasil dihapus!');
    }
}
