@extends('layout.master2')

@section('content')
<style>
    .table-wrapper {
        max-height: 100%;
        overflow-x: auto;
    }

    #agendaTable {
        border-collapse: collapse;
        width: max-content;
        min-width: 100%;
        table-layout: auto;
    }

    #agendaTable thead th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 10;
    }

    #agendaTable th,
    #agendaTable td {
        vertical-align: middle;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        text-align: center;
        padding: 8px;
    }

    #agendaTable th:nth-child(2),
    #agendaTable th:nth-child(3),
    #agendaTable th:nth-child(4),
    #agendaTable th:nth-child(8),
    #agendaTable td:nth-child(2),
    #agendaTable td:nth-child(3),
    #agendaTable td:nth-child(4),
    #agendaTable td:nth-child(8) {
        text-align: left;
    }
</style>

<div class="container-fluid mt-4">
    <div class="card shadow rounded-3 p-4">
        <div class="d-flex justify-content-center align-items-center gap-4 mb-4">
            <img src="{{ url('assets/images/LogoKabupatenBrebes.png') }}" style="height: 60px;">
            <h1 class="mb-0 text-center">JADWAL AGENDA RSUD BREBES</h1>
            <img src="{{ url('assets/images/logo_rsud_brebes.png') }}" style="height: 60px;">
        </div>
        {{-- Tabel Hari Ini --}}
        <div class="table-wrapper">
            <table id="agendaTable" class="table table-striped table-hover table-bordered">
                <thead class="table-light align-middle text-center">
                    <tr>
                        <th colspan="8">JADWAL AGENDA HARI INI</th>
                    </tr>
                    <tr>
                        <th style="width: 5%;" class="text-center">NO</th>
                        <th style="width: 15%;" class="text-center">RUANGAN</th>
                        <th style="width: 30%;" class="text-center">NAMA RAPAT</th>
                        <th style="width: 18%;" class="text-center">HARI, TANGGAL</th>
                        <th style="width: 15%;" class="text-center">WAKTU</th>
                        <th style="width: 7%;" class="text-center">JUMLAH PESERTA</th>
                        <th style="width: 10%;" class="text-center">PESANAN</th>
                        <th style="width: 15%;" class="text-center">PIC</th>
                    </tr>
                </thead>
                <tbody id="agenda-body-hari-ini">
                    @forelse($jadwal_hari_ini as $rapat)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rapat->nama_ruangan }}</td>
                        <td>{{ $rapat->nama_rapat }}</td>
                        <td>{{ \Carbon\Carbon::parse($rapat->tanggal)->locale('id')->translatedFormat('l, d F Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($rapat->jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($rapat->jam_selesai)->format('H:i') }} WIB</td>
                        <td>{{ $rapat->jumlah_peserta }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $rapat->jumlah_snack }} SNACK</span> -
                            <span class="badge bg-primary">{{ $rapat->jumlah_makan }} MAKAN</span>
                        </td>
                        <td>
                            {{ $rapat->gelar_depan ? $rapat->gelar_depan . '. ' : '' }}
                            {{ Str::title(strtolower($rapat->nama)) }}
                            {{ $rapat->gelar_belakang ? ', ' . $rapat->gelar_belakang : '' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada jadwal agenda yang terjadwal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Tabel Hari Berikutnya --}}
        <div class="table-wrapper mt-5">
            <table id="agendaTable" class="table table-striped table-hover table-bordered">
                <thead class="table-light align-middle text-center">
                    <tr>
                        <th colspan="8">JADWAL AGENDA HARI SELANJUTNYA</th>
                    </tr>
                    <tr>
                        <th style="width: 5%;" class="text-center">NO</th>
                        <th style="width: 15%;" class="text-center">RUANGAN</th>
                        <th style="width: 30%;" class="text-center">NAMA RAPAT</th>
                        <th style="width: 18%;" class="text-center">HARI, TANGGAL</th>
                        <th style="width: 15%;" class="text-center">WAKTU</th>
                        <th style="width: 7%;" class="text-center">JUMLAH PESERTA</th>
                        <th style="width: 10%;" class="text-center">PESANAN</th>
                        <th style="width: 15%;" class="text-center">PIC</th>
                    </tr>
                </thead>
                <tbody id="agenda-body-berikutnya">
                    @forelse($jadwal_berikutnya as $rapat2)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rapat2->nama_ruangan }}</td>
                        <td>{{ $rapat2->nama_rapat }}</td>
                        <td>{{ \Carbon\Carbon::parse($rapat2->tanggal)->locale('id')->translatedFormat('l, d F Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($rapat2->jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($rapat2->jam_selesai)->format('H:i') }} WIB</td>
                        <td>{{ $rapat2->jumlah_peserta }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $rapat2->jumlah_snack }} SNACK</span> -
                            <span class="badge bg-primary">{{ $rapat2->jumlah_makan }} MAKAN</span>
                        </td>
                        <td>
                            {{ $rapat2->gelar_depan ? $rapat2->gelar_depan . '. ' : '' }}
                            {{ Str::title(strtolower($rapat2->nama)) }}
                            {{ $rapat2->gelar_belakang ? ', ' . $rapat2->gelar_belakang : '' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada jadwal agenda yang terjadwal.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    setTimeout(() => window.location.reload(), 60000);

    function jalankanScroll(tbodyId, maxVisible = 20, intervalMs = 10000) {
        const tbody = document.getElementById(tbodyId);
        if (!tbody) return;

        const rows = Array.from(tbody.querySelectorAll('tr'));
        if (rows.length <= maxVisible) return;

        let index = 0;
        const queue = [...rows];

        tbody.innerHTML = "";
        for (let i = 0; i < maxVisible; i++) {
            tbody.appendChild(queue[i]);
        }

        setInterval(() => {
            const removed = tbody.firstElementChild;
            tbody.removeChild(removed);

            index = (index + 1) % queue.length;
            const nextIndex = (index + maxVisible - 1) % queue.length;
            const nextRow = queue[nextIndex].cloneNode(true);

            tbody.appendChild(nextRow);
        }, intervalMs);
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        }

        jalankanScroll('agenda-body-hari-ini');
        jalankanScroll('agenda-body-berikutnya');
    });
</script>
@endsection