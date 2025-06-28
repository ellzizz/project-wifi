@extends('layouts.main')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Dashboard Admin</h2>
        <p class="text-muted">Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Kelola data pengguna dan pemasangan WiFi di sini.</p>
    </div>

    <!-- Data Pemasangan -->
    <div class="card shadow mb-5">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Data Pemasangan Teknisi</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Catatan Teknisi</th>
                        <th>Keterangan Admin</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemasangans as $p)
                        <tr>
                            <td>{{ $p->user->name }}</td>
                            <td>{{ $p->alamat }}</td>
                            <td>
                                <span class="badge bg-{{ $p->status === 'selesai' ? 'success' : 'warning' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td>{{ $p->catatan ?? '-' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.keterangan.update', $p->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="keterangan_admin" class="form-control form-control-sm" rows="1" placeholder="Tulis keterangan...">{{ $p->keterangan_admin }}</textarea>
                                    <button class="btn btn-sm btn-outline-success mt-1" type="submit">Simpan</button>
                                </form>
                            </td>
                            <td>{{ $p->created_at->format('d M Y H:i') }}</td>
                            <td>
                                {{-- Tambahan opsional aksi admin ke pemasangan --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada pemasangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- CRUD Pengguna -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Manajemen Pengguna</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td><span class="badge bg-secondary">{{ $u->role }}</span></td>
                            <td>
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
