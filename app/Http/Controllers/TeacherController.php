<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $teachers = Teacher::query()
            ->when($request->field, fn ($q, $f) => $q->where('field', $f))
            ->when($request->search, fn ($q, $s) => $q->where('name', 'like', "%$s%"))
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $fields = Teacher::where('is_active', true)->whereNotNull('field')->distinct()->orderBy('field')->pluck('field');

        return view('guru.index', compact('teachers', 'fields'));
    }

    public function show(Teacher $teacher)
    {
        abort_unless($teacher->is_active, 404);

        return view('guru.show', compact('teacher'));
    }
}
