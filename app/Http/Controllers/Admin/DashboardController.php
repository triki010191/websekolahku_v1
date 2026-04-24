<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Major;
use App\Models\Post;
use App\Models\PpdbRegistration;
use App\Models\Teacher;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $stats = [
            'students'     => Major::sum('student_count'),
            'teachers'     => Teacher::where('is_active', true)->count(),
            'ppdb_total'   => PpdbRegistration::count(),
            'ppdb_pending' => PpdbRegistration::where('status', 'pending')->count(),
            'posts'        => Post::count(),
            'announcements'=> Announcement::count(),
            'messages_new' => ContactMessage::where('status', 'new')->count(),
            'users'        => User::count(),
        ];

        $latest = [
            'posts'    => Post::latest()->take(5)->with('author')->get(),
            'ppdb'     => PpdbRegistration::latest()->take(5)->with('major')->get(),
            'messages' => ContactMessage::latest()->take(5)->get(),
        ];

        $ppdbByMajor = Major::where('is_active', true)
            ->withCount('ppdbRegistrations')
            ->get()
            ->map(fn ($m) => ['label' => $m->code, 'value' => $m->ppdb_registrations_count, 'quota' => $m->quota]);

        return view('admin.dashboard', compact('stats', 'latest', 'ppdbByMajor'));
    }
}
