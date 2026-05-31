<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TeachersExport;
use App\Exports\TeachersTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\TeachersImport;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->orderBy('sort_order')->orderBy('name')->paginate(20);

        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $linkableUsers = $this->linkableUsers();

        return view('admin.teachers.form', ['teacher' => new Teacher, 'linkableUsers' => $linkableUsers]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['slug'] = $this->makeSlug($data['name']);
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request);
        }

        $teacher = Teacher::create($data);
        $this->syncUserLink($request, $teacher);

        return redirect()->route('admin.teachers.index')->with('success', 'Guru/TU ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        $teacher->load('user');
        $linkableUsers = $this->linkableUsers($teacher);

        return view('admin.teachers.form', compact('teacher', 'linkableUsers'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($teacher->name !== $data['name']) {
            $data['slug'] = $this->makeSlug($data['name'], $teacher->id);
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request);
        }
        $teacher->update($data);
        $this->syncUserLink($request, $teacher);

        return redirect()->route('admin.teachers.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return back()->with('success', 'Data dihapus.');
    }

    public function exportExcel(): BinaryFileResponse
    {
        return Excel::download(new TeachersExport, 'data-guru-tu-'.now()->format('Y-m-d').'.xlsx');
    }

    public function exportTemplate(): BinaryFileResponse
    {
        return Excel::download(new TeachersTemplateExport, 'template-import-guru-tu.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ]);

        $import = new TeachersImport;
        Excel::import($import, $request->file('file'));

        return back()->with('success', "Import selesai: {$import->created} ditambah, {$import->updated} diperbarui.");
    }

    private function validated(Request $r): array
    {
        return $r->validate([
            'nip'               => ['nullable', 'string', 'max:30'],
            'name'              => ['required', 'string', 'max:255'],
            'gender'            => ['required', 'in:L,P'],
            'position'          => ['required', 'string', 'max:255'],
            'subject'           => ['nullable', 'string', 'max:255'],
            'education'         => ['nullable', 'string', 'max:255'],
            'employment_status' => ['required', 'in:pns,pppk,honorer'],
            'field'             => ['nullable', 'string', 'max:50'],
            'email'             => ['nullable', 'email', 'max:255'],
            'phone'             => ['nullable', 'string', 'max:32'],
            'motto'             => ['nullable', 'string', 'max:500'],
            'bio'               => ['nullable', 'string'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
            'photo'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'user_id'           => ['nullable', 'exists:users,id'],
            'create_login'      => ['nullable', 'boolean'],
            'login_email'       => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')],
            'login_password'    => ['nullable', Password::min(6)],
        ]);
    }

    private function syncUserLink(Request $request, Teacher $teacher): void
    {
        if ($request->boolean('create_login')) {
            $email = $request->input('login_email') ?: $teacher->email;
            abort_if(! $email, 422, 'Email akun login wajib diisi untuk membuat akun.');

            $user = User::create([
                'name'     => $teacher->name,
                'email'    => $email,
                'password' => Hash::make($request->input('login_password') ?: 'guru123456'),
                'role'     => User::ROLE_GURU,
                'status'   => 'active',
            ]);

            $teacher->update(['user_id' => $user->id]);

            return;
        }

        if ($request->filled('user_id')) {
            $user = User::where('id', $request->input('user_id'))
                ->where('role', User::ROLE_GURU)
                ->firstOrFail();

            Teacher::where('user_id', $user->id)->where('id', '!=', $teacher->id)->update(['user_id' => null]);
            $teacher->update(['user_id' => $user->id]);
        }
    }

    /** @return \Illuminate\Support\Collection<int, User> */
    private function linkableUsers(?Teacher $current = null)
    {
        $linkedIds = Teacher::whereNotNull('user_id')
            ->when($current?->id, fn ($q) => $q->where('id', '!=', $current->id))
            ->pluck('user_id');

        return User::where('role', User::ROLE_GURU)
            ->whereNotIn('id', $linkedIds)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }

    private function makeSlug(string $name, ?int $exceptId = null): string
    {
        $base = Str::slug($name) ?: 'guru';
        $slug = $base;
        $i = 1;
        while (Teacher::where('slug', $slug)->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    private function storePhoto(Request $request): string
    {
        $dir = storage_path('app/public/teachers');
        if (! is_dir($dir) && ! mkdir($dir, 0775, true) && ! is_dir($dir)) {
            throw ValidationException::withMessages([
                'photo' => 'Folder upload tidak bisa dibuat. Hubungi administrator server.',
            ]);
        }
        if (! is_writable($dir)) {
            throw ValidationException::withMessages([
                'photo' => 'Folder storage/teachers tidak bisa ditulis. Minta admin jalankan: chmod -R 775 storage/app/public',
            ]);
        }

        try {
            $path = $request->file('photo')->store('teachers', 'public');
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                'photo' => 'Gagal menyimpan foto: '.$e->getMessage(),
            ]);
        }

        if (! Storage::disk('public')->exists($path)) {
            throw ValidationException::withMessages([
                'photo' => 'Foto gagal disimpan ke server.',
            ]);
        }

        return $path;
    }
}
