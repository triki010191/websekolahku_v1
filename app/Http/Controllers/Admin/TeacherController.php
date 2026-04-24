<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderBy('sort_order')->orderBy('name')->paginate(20);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.form', ['teacher' => new Teacher()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('photo')) $data['photo'] = $request->file('photo')->store('teachers', 'public');
        Teacher::create($data);
        return redirect()->route('admin.teachers.index')->with('success', 'Guru/TU ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.form', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('photo')) $data['photo'] = $request->file('photo')->store('teachers', 'public');
        $teacher->update($data);
        return redirect()->route('admin.teachers.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return back()->with('success', 'Data dihapus.');
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'nip'      => ['nullable', 'string', 'max:30'],
            'name'     => ['required', 'string', 'max:255'],
            'gender'   => ['required', 'in:L,P'],
            'position' => ['required', 'string', 'max:255'],
            'subject'  => ['nullable', 'string', 'max:255'],
            'employment_status' => ['required', 'in:pns,pppk,honorer'],
            'field'    => ['nullable', 'string', 'max:50'],
            'email'    => ['nullable', 'email', 'max:255'],
            'phone'    => ['nullable', 'string', 'max:32'],
            'bio'      => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'photo'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
