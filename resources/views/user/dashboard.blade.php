@extends('layouts.main')

@section('content')
<div class="container py-4">

<!-- Banner Gambar Responsif & Aman -->
<div class="text-center mb-4">
    <div style="max-height: 250px; overflow: hidden; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <img 
            src="https://arrowvoice.com.au/wp-content/uploads/2017/08/BE_banners_WIFI_2000x730.jpg" 
            class="img-fluid w-100" 
            alt="Banner WiFi"
            style="object-fit: cover; height: 100%; width: 100%;"
        >
    </div>
</div>

    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Dashboard Pengguna</h2>
        <p class="text-muted">Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Kelola pemasangan WiFi kamu di sini.</p>
    </div>

    <!-- Form Pemasangan Baru -->
    <div class="card shadow mb-5">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Ajukan Pemasangan Baru</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.pasang') }}">
                @csrf
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Pemasangan</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Contoh: Jl. Melati No.10" required>
                </div>

                <div class="mb-3">
                    <label for="paket" class="form-label">Pilih Paket WiFi</label>
                    <select name="paket" id="paket" class="form-select" required>
                        <option value="">-- Pilih Paket --</option>
                        <option value="basic">Basic - 10 Mbps</option>
                        <option value="standar">Standar - 30 Mbps</option>
                        <option value="premium">Premium - 50 Mbps</option>
                    </select>
                </div>

                <div id="paket-info" class="alert alert-info d-none"></div>

                <button type="submit" class="btn btn-success mt-2 w-100">Ajukan Pemasangan</button>
            </form>
        </div>
    </div>

    <!-- Status Pemasangan -->
    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Status Pemasangan Kamu</h5>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @forelse($pemasangans as $p)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $p->alamat }}</strong><br>
                            <small class="text-muted">Status: {{ $p->status }}</small>
                        </div>
                        <span class="badge bg-{{ $p->status == 'selesai' ? 'success' : 'warning' }}">{{ ucfirst($p->status) }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">Belum ada pemasangan.</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>

<!-- JavaScript paket WiFi -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectPaket = document.getElementById('paket');
        const paketInfo = document.getElementById('paket-info');

        const paketDeskripsi = {
            basic: '<strong>Basic</strong>: Kecepatan <strong>10 Mbps</strong>. Cocok untuk penggunaan ringan seperti browsing & chatting.',
            standar: '<strong>Standar</strong>: Kecepatan <strong>30 Mbps</strong>. Ideal untuk streaming HD & meeting online.',
            premium: '<strong>Premium</strong>: Kecepatan <strong>50 Mbps</strong>. Untuk keluarga besar, streaming 4K & smart home.'
        };

        selectPaket.addEventListener('change', function () {
            const value = this.value;
            if (paketDeskripsi[value]) {
                paketInfo.innerHTML = paketDeskripsi[value];
                paketInfo.classList.remove('d-none');
            } else {
                paketInfo.classList.add('d-none');
            }
        });
    });
    
</script>

@endsection
