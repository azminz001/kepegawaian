@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Rapat</li>
        <li class="breadcrumb-item" aria-current="page">Jadwal Rapat</li>
        <li class="breadcrumb-item active" aria-current="page">Kehadiran</li>
    </ol>
</nav>
<div class="row profile-body">
    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 mx-auto grid-margin">
                <div class="card rounded">
                    <div class="card-body">
                        <table>
                            <tr>
                                <td><strong>Nama Agenda</strong></td>
                                <td width="10%">
                                    <center>:</center>
                                </td>
                                <td>{{ strtoupper($rapat->nama_rapat) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Hari, Tanggal</strong></td>
                                <td width="10%">
                                    <center>:</center>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pukul</strong></td>
                                <td width="10%">
                                    <center>:</center>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($rapat->jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($rapat->jam_selesai)->format('H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat</strong></td>
                                <td width="10%">
                                    <center>:</center>
                                </td>
                                <td>{{ $rapat->nama }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <!-- Tombol Kembali -->
                            <a href="{{ url('/rapat/jadwal_rapat?id_ruang=' . $rapat->id_ruang) }}" class="btn btn-sm btn-secondary">
                                <i data-feather="arrow-left"></i> Kembali
                            </a>

                            <!-- Tombol Cetak -->
                            <a href="{{ route('rapat.kehadiran_rapat.cetak', $rapat->uuid) }}" target="_blank" class="btn btn-default btn-sm">
                                <i data-feather="printer"></i> CETAK
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#tambahKehadiran">
                                    <i data-feather="plus"></i> TAMBAH KEHADIRAN
                                </button>
                            </div>
                            <div class="col-md-9">
                                <form action="{{ route('rapat.kehadiran_rapat.index') }}" method="GET">
                                    <input type="hidden" name="uuid_jadwal_rapat" value="{{ request('uuid_jadwal_rapat') }}">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <i data-feather="search"></i>
                                        </div>
                                        <input type="text" name="cari" class="form-control" placeholder="cari nama peserta ..." value="{{ request('cari') }}">
                                        <button type="submit" class="btn btn-secondary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA LENGKAP</th>
                                        <th>NIP / NRP</th>
                                        <th>INSTANSI / ORGANISASI</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kehadirans as $index => $kehadiran)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $kehadiran->nama_peserta }}</td>
                                        <td>{{ $kehadiran->nip_nrp }}</td>
                                        <td>{{ $kehadiran->instansi }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-1">
                                                <form onsubmit="return confirm('Apakah Anda yakin menghapus kehadiran {{ $kehadiran->nama_rapat }} ({{ $kehadiran->nip_nrp }}) ini?');"
                                                    action="{{ route('rapat.kehadiran_rapat.destroy', $kehadiran->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon" data-bs-toggle="tooltip" title="Hapus">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada kehadiran untuk rapat ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $kehadirans->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="tambahKehadiran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">TAMBAH KEHADIRAN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="formulirTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pegawai-tab" data-bs-toggle="tab" data-bs-target="#pegawai" type="button" role="tab">
                                    Pegawai RSUD Brebes
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nonpegawai-tab" data-bs-toggle="tab" data-bs-target="#nonpegawai" type="button" role="tab">
                                    Bukan Pegawai RSUD Brebes
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="formulirTabsContent">
                            {{-- Tab Pegawai --}}
                            <div class="tab-pane fade show active" id="pegawai" role="tabpanel">
                                <form method="POST" action="{{ route('rapat.kehadiran_rapat.store') }}">
                                    @csrf
                                    <input type="hidden" name="uuid_jadwal_rapat" value="{{ $rapat->uuid }}">
                                    <input type="hidden" name="instansi" value="RSUD Brebes">

                                    <div class="mb-3">
                                        <label for="pegawai_id" class="form-label">Nama Lengkap dan Gelar</label>
                                        <select name="pegawai_id" class="form-control select2" data-width="100%" required>
                                            <option value="">-- PILIH NAMA / NOMOR PEGAWAI ANDA</option>
                                            @foreach ($pegawais as $pegawai)
                                            <option value="{{ $pegawai->id }}">
                                                {{ $pegawai->gelar_depan ? $pegawai->gelar_depan . '. ' : '' }}
                                                {{ Str::title(strtolower($pegawai->nama)) }}
                                                {{ $pegawai->gelar_belakang ? ', ' . $pegawai->gelar_belakang : '' }}
                                                ({{ $pegawai->nip_nipppk_nrpk_nrpblud }})
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('pegawai_id')
                                        <code>{{ $message }}</code>
                                        @enderror
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">HADIR</button>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab Non Pegawai --}}
                            <div class="tab-pane fade" id="nonpegawai" role="tabpanel">
                                <form method="POST" action="{{ route('rapat.kehadiran_rapat.store') }}">
                                    @csrf
                                    <input type="hidden" name="uuid_jadwal_rapat" value="{{ $rapat->uuid }}">

                                    <div class="mb-3">
                                        <label for="nama_peserta" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_peserta" placeholder="Masukkan nama beserta gelar ..." required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nip_nrp" class="form-label">NIP / NRP</label>
                                        <input type="number" class="form-control" name="nip_nrp" placeholder="Masukkan NIP atau NRP ..." required>
                                    </div>

                                    <div class="mb-5">
                                        <label for="instansi" class="form-label">Asal Instansi / Organisasi</label>
                                        <input type="text" name="instansi" class="form-control" placeholder="Contoh: Dinas Kesehatan, Polres Brebes" required>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">HADIR</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tambahKehadiran').on('shown.bs.modal', function() {
            $('.select2').select2({
                dropdownParent: $('#tambahKehadiran')
            });
        });
    });
</script>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>