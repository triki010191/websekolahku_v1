<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlumniProfile;
use Illuminate\Http\Request;

class AlumniProfileController extends Controller
{
    public function index()
    {
        $profiles = AlumniProfile::with(['user', 'major'])
            ->latest()
            ->paginate(20);

        return view('admin.alumni-profiles.index', compact('profiles'));
    }

    public function updateVerification(Request $request, AlumniProfile $alumniProfile)
    {
        $data = $request->validate([
            'verification' => ['required', 'in:pending,verified,rejected'],
        ]);

        $alumniProfile->update($data);

        return back()->with('success', 'Status verifikasi alumni diperbarui.');
    }
}
