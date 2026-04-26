<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\AlumniProfile;
use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Event;
use App\Models\HeroSlide;
use App\Models\Major;
use App\Models\Partner;
use App\Models\Post;
use App\Models\Teacher;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home.index', [
            'heroSlides' => HeroSlide::active()->get(),
            'banners' => Banner::active()->get(),
            'majors' => Major::where('is_active', true)->orderBy('sort_order')->get(),
            'posts' => Post::published()->latest('published_at')->take(6)->get(),
            'announcements' => Announcement::active()->orderByDesc('published_at')->take(5)->get(),
            'events' => Event::upcoming()->take(4)->get(),
            'partners' => Partner::where('is_active', true)->orderBy('sort_order')->take(8)->get(),
            'achievements' => Achievement::latest('year')->take(4)->get(),
            'testimonials' => AlumniProfile::where('verification', 'verified')
                ->with(['user', 'major'])
                ->whereNotNull('bio')
                ->latest()
                ->take(3)
                ->get(),
            'stats' => [
                'students' => Major::sum('student_count') ?: 0,
                'teachers' => Teacher::where('is_active', true)->count(),
                'majors' => Major::where('is_active', true)->count(),
                'alumni' => AlumniProfile::where('verification', 'verified')->count(),
            ],
        ]);
    }
}
