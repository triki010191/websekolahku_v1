@extends('layouts.admin')

@section('title', 'Data alumni')

@section('admin')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h1 class="h4 mb-0">Data alumni</h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 small">
            <thead class="table-light">
                <tr>
                    <th>Nama / Email</th>
                    <th>Jurusan</th>
                    <th>Lulus</th>
                    <th>Verifikasi</th>
                    <th class="text-end" style="min-width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($profiles as $p)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $p->user?->name }}</div>
                        <div class="text-secondary">{{ $p->user?->email }}</div>
                    </td>
                    <td>{{ $p->major?->name ?? '—' }}</td>
                    <td>{{ $p->graduation_year ?? '—' }}</td>
                    <td>
                        <span @class(['badge', 'bg-success' => $p->verification === 'verified', 'bg-danger' => $p->verification === 'rejected', 'bg-warning text-dark' => $p->verification === 'pending'])>
                            {{ $p->verification }}
                        </span>
                    </td>
                    <td class="text-end">
                        <form method="post" action="{{ route('admin.alumni-profiles.verification', $p) }}" class="d-flex flex-wrap gap-1 justify-content-end align-items-center">
                            @csrf
                            @method('PUT')
                            <select name="verification" class="form-select form-select-sm" style="width: auto; max-width: 140px;">
                                <option value="pending" @selected($p->verification === 'pending')>pending</option>
                                <option value="verified" @selected($p->verification === 'verified')>verified</option>
                                <option value="rejected" @selected($p->verification === 'rejected')>rejected</option>
                            </select>
                            <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada data alumni.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($profiles->hasPages())
    <div class="card-body border-top py-2">{{ $profiles->links() }}</div>
    @endif
</div>
@endsection
