<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobVacancy as Job;
use App\Exports\ApplicationsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    /**
     * Menampilkan daftar seluruh pelamar (Khusus Admin)
     */
    public function index()
    {
        // Ambil data aplikasi beserta relasi user dan job
        $applications = Application::with(['user', 'job'])->latest()->get();
        return view('applications.index', compact('applications'));
    }

    /**
     * Mengubah status lamaran (Accepted/Rejected)
     */
    public function update(Request $request, Application $application)
    {
        // Ubah status sesuai tombol yang diklik (Accepted/Rejected)
        $application->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pelamar berhasil diperbarui.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jobId)
    {
        // 1. Validasi input (Hanya menerima file PDF/DOC, maks 2MB)
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        // 2. Cek apakah user sudah pernah melamar di pekerjaan ini?
        $existingApplication = Application::where('user_id', Auth::id())
                                        ->where('job_id', $jobId)
                                        ->first();

        if ($existingApplication) {
            return back()->with('error', 'Anda sudah melamar pekerjaan ini sebelumnya.');
        }

        // 3. Simpan File CV
        $cvPath = $request->file('cv')->store('cvs', 'public');

        // 4. Simpan Data Lamaran ke Database
        Application::create([
            'user_id' => Auth::id(),
            'job_id' => $jobId,
            'cv' => $cvPath,
            'status' => 'Pending', // Status default
        ]);

        return back()->with('success', 'Lamaran berhasil dikirim! Semoga beruntung.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export()
    {
        return Excel::download(new ApplicationsExport,'applications.xlsx');
    }
}
