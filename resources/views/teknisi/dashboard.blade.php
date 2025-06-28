@extends('layouts.main')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">Dashboard Teknisi</h2>
        <p class="text-muted">Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Berikut daftar pemasangan WiFi yang perlu kamu tangani.</p>
    </div>

    <!-- Ilustrasi Teknisi -->
    <div class="text-center mb-5">
        <img src="https://cdn-icons-png.flaticon.com/512/3371/3371747.png" 
             alt="Teknisi WiFi" 
             style="max-height: 160px;" 
             class="img-fluid mb-3">
        <p class="text-muted small">Pastikan setiap pemasangan dilakukan sesuai prosedur dan standar instalasi.</p>
    </div>

    <!-- Daftar Pemasangan -->
    <div class="card shadow mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">Daftar Pemasangan Belum Selesai</h5>
        </div>
        <div class="card-body">
            @forelse($pemasangans as $p)
                <div class="list-group mb-3">
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>📍 {{ $p->alamat }}</strong><br>
                                <small>Status: 
                                    <span class="badge bg-{{ $p->status == 'selesai' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </small>
                            </div>
                            <button class="btn btn-outline-primary btn-sm" onclick="toggleForm({{ $p->id }})">
                                Update Status
                            </button>
                        </div>

                        <!-- Form Update (hidden by default) -->
                        <form id="form-{{ $p->id }}" action="{{ route('teknisi.update', $p->id) }}" method="POST" class="mt-3 d-none">
                            @csrf
                            @method('PATCH')

                            <div class="mb-2">
                                <label for="status-{{ $p->id }}" class="form-label">Status Pemasangan</label>
                                <select name="status" id="status-{{ $p->id }}" class="form-select" required>
                                    <option value="proses" {{ $p->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="catatan-{{ $p->id }}" class="form-label">Catatan Teknisi</label>
                                <textarea name="catatan" id="catatan-{{ $p->id }}" class="form-control" rows="2">{{ $p->catatan ?? '' }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-success btn-sm">Simpan Perubahan</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="toggleForm({{ $p->id }})">Batal</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="alert alert-secondary text-center mb-0">Tidak ada pemasangan saat ini.</div>
            @endforelse
        </div>
    </div>

    <!-- Prosedur Pemasangan -->
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Prosedur dan Langkah Pemasangan</h5>
        </div>
        <div class="card-body">
            <ol class="ps-3">
                <li><strong>Verifikasi Alamat:</strong> Pastikan alamat sesuai dengan data pemesanan.</li>
                <li><strong>Persiapkan Peralatan:</strong> Router, kabel LAN, alat bor, dan perangkat pemasangan lainnya.</li>
                <li><strong>Instalasi Kabel & Perangkat:</strong> Pasang kabel dari sumber jaringan ke lokasi user dengan rapi.</li>
                <li><strong>Konfigurasi Router:</strong> Atur SSID dan password sesuai standar perusahaan.</li>
                <li><strong>Uji Koneksi:</strong> Pastikan internet berjalan lancar, uji kecepatan dan kestabilan.</li>
                <li><strong>Foto Dokumentasi:</strong> Ambil foto hasil pemasangan sebagai bukti kerja.</li>
                <li><strong>Update Status:</strong> Tandai status pemasangan menjadi <code>selesai</code> melalui tombol yang tersedia.</li>
            </ol>
        </div>
    </div>

</div>

<!-- Script Toggle Form -->
<script>
    function toggleForm(id) {
        const form = document.getElementById(`form-${id}`);
        form.classList.toggle('d-none');
    }
</script>
@endsection
