@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Manajemen Pengguna</h4>
            <p class="text-muted mb-0">Kelola akun staf dan administrator</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Nama</th>
                            <th>Email</th>
                            <th>No. HP</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $u->avatar_url }}" alt="{{ $u->name }}" class="rounded-circle me-3" width="40" height="40">
                                    <div class="fw-bold">{{ $u->name }}</div>
                                </div>
                            </td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->phone ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $u->role_color }} rounded-pill">
                                    <i class="bi {{ $u->role_icon }} me-1"></i>
                                    {{ $u->role_label }}
                                </span>
                            </td>
                            <td>
                                @if($u->is_active)
                                    <span class="badge bg-success-subtle text-success rounded-pill"><i class="bi bi-check-circle me-1"></i> Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-pill"><i class="bi bi-x-circle me-1"></i> Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('users.edit', $u) }}" class="btn btn-sm btn-outline-secondary" title="Edit Pengguna">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    @if(auth()->id() !== $u->id)
                                    <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Pengguna">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-sm btn-outline-danger disabled" title="Tidak dapat menghapus diri sendiri">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-people display-4 d-block mb-3 opacity-50"></i>
                                Belum ada data pengguna.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
