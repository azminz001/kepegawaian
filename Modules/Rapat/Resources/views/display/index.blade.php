@extends('layout.master2')


@section('content')
<div class="container-fluid mt-4">
    @if (!request()->filled('id_ruang'))
    <div class="row profile-body">
        @foreach ($ruang_rapat as $ruangan)
        <div class="col-sm-12 col-md-3 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 style="color: #6571FF; text-align: center;">{{$ruangan->nama}}</h4>
                    <h6 style="text-align: center;">KAPASITAS PESERTA</h6><br>
                    <h1 style="text-align: center;">{{$ruangan->kapasitas}}</h1><br>
                    <form method="GET" action="" method="GET">
                        <input type="hidden" name="id_ruang" value="{{$ruangan->id}}" onchange="this.form.submit()" id="id_ruang">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">LIHAT</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    @if (request('id_ruang'))
    @php
    $ruang = $ruang_rapat->firstWhere('id', request('id_ruang'));
    @endphp

    <div class="card shadow rounded-3 p-4">
        <h1 class="text-center mb-4 text-uppercase">{{ $ruang ? $ruang->nama : 'RUANG PERTEMUAN' }}</h1>
        @if ($jadwal_saat_ini)
        <div class="bg-primary text-white p-4 rounded d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0">Sedang berlangsung :</h4>
                <h2 class="mb-1 text-uppercase">AGENDA {{ $jadwal_saat_ini->nama_rapat }}</h2>
                <h4 class="mb-0">
                    {{ \Carbon\Carbon::parse($jadwal_saat_ini->tanggal)->translatedFormat('l, d F Y') }} Pukul {{ \Carbon\Carbon::parse($jadwal_saat_ini->jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($jadwal_saat_ini->jam_selesai)->format('H:i') }} WIB
                </h4>
            </div>
            <div class="text-center">
                <div class="bg-white p-2 rounded">
                    <div class="text-dark mb-1">Scan Kehadiran</div>
                    {!! QrCode::size(100)->generate(route('rapat.kehadiran_rapat.form', $jadwal_saat_ini->uuid)) !!}
                </div>
            </div>
        </div>
        @else
        <div class="bg-primary text-white p-4 rounded d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-0">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </h4>
                <h2 class="mb-1 text-uppercase">BELUM ADA ACARA YANG BERLANGSUNG SAAT INI</h2>
            </div>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th colspan="5">DAFTAR AGENDA SELANJUTNYA UNTUK {{ strtoupper($ruang ? $ruang->nama : '-') }}</th>
                    </tr>
                    <tr>
                        <th width="3%">NO</th>
                        <th>NAMA RAPAT</th>
                        <th width="3%">WAKTU</th>
                        <th width="3%">JUMLAH PESERTA</th>
                        <th width="3%">PIC</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal_rapat as $rapat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rapat->nama_rapat }}</td>
                        <td>{{ \Carbon\Carbon::parse($rapat->jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($rapat->jam_selesai)->format('H:i') }} WIB</td>
                        <td>{{ $rapat->jumlah_peserta }}</td>
                        <td>
                            {{ $rapat->gelar_depan ? $rapat->gelar_depan . '. ' : '' }}
                            {{ Str::title(strtolower($rapat->nama)) }}
                            {{ $rapat->gelar_belakang ? ', ' . $rapat->gelar_belakang : '' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada jadwal rapat selanjutnya</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('rapat.display_rapat.index') }}" class="btn btn-secondary mt-5">
            <i data-feather="arrow-left"></i> KEMBALI KE DAFTAR RUANGAN
        </a>
    </div>
    @endif
</div>

<script>
    // Auto reload setiap 1 menit
    setTimeout(() => window.location.reload(), 60000);

    // Auto fullscreen saat load
    document.addEventListener('DOMContentLoaded', function() {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen();
        }

        // Auto scroll atas-bawah
        let scrollDown = true;
        setInterval(function() {
            const scrollHeight = document.body.scrollHeight;
            const clientHeight = document.documentElement.clientHeight;

            if (scrollDown) {
                window.scrollBy({
                    top: 1,
                    behavior: 'smooth'
                });
                if ((window.innerHeight + window.scrollY) >= scrollHeight) {
                    scrollDown = false;
                }
            } else {
                window.scrollBy({
                    top: -1,
                    behavior: 'smooth'
                });
                if (window.scrollY === 0) {
                    scrollDown = true;
                }
            }
        }, 50);
    });
</script>

@endsection