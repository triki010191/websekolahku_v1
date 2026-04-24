<?php

namespace App\Http\Controllers;

use App\Models\AlumniJob;
use App\Models\AlumniProfile;

class AlumniController extends Controller
{
    public function index()
    {
        $profiles = AlumniProfile::where('verification', 'verified')
            ->with(['user', 'major'])
            ->latest()
            ->paginate(12);

        $jobs = AlumniJob::where('status', 'active')->latest()->take(4)->get();

        return view('alumni.index', compact('profiles', 'jobs'));
    }

    public function jobs()
    {
        $jobs = AlumniJob::where('status', 'active')->latest()->paginate(10);
        return view('alumni.jobs', compact('jobs'));
    }
}
