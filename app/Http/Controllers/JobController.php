<?php

namespace App\Http\Controllers;

use App\Imports\JobsImport;
use App\Models\JobVacancy as Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class JobController extends Controller
{
    public function index(){
        $jobs = Job::all(); 
        return view('jobs.index', compact('jobs'));
    }

    public function store(Request $request)
    {
        $request->validate([ 
            'title' => 'required', 
            'description' => 'required', 
            'location' => 'required', 
            'company' => 'required', 
            'salary' => 'required|integer',
            'logo' => 'image|mimes:jpg,png,jpeg|max:2048' 
        ]); 
 
        $logoPath = null; 
        if ($request->hasFile('logo')) { 
            $logoPath = $request->file('logo')->store('logos', 'public'); 
        }

        Job::create([
            'title' => $request->title, 
            'description' => $request->description, 
            'location' => $request->location, 
            'company' => $request->company, 
            'salary' => $request->salary, 
            'logo' => $logoPath
        ]);

        return redirect()->route('jobs.index')
                        ->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function create()
    {
        return view('jobs.create'); 
    }

    public function show(Job $job)
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'salary' => 'required|integer|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'logo']);

        if ($request->hasFile('logo')) {
            if ($job->logo) {
                Storage::disk('public')->delete($job->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $job->update($data);

        return redirect()->route('jobs.index')
                         ->with('success', 'Lowongan pekerjaan berhasil diperbarui');
    }

    public function destroy(Job $job)
    {
        if ($job->logo){
            Storage::disk('public')->delete($job->logo);
        }

        $job->delete();

        return redirect()->route('jobs.index')
                         ->with('success', 'Lowongan pekerjaan berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new JobsImport, $request->file('file'));

        return back()->with('success', 'Data lowongan berhasil diimport!');
    }
}
