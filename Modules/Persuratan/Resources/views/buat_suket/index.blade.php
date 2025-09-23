@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@php
use Illuminate\Support\Str;
use Carbon\Carbon;
@endphp

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Persuratan</li>
        <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Keterangan</li>
    </ol>
</nav>
<div class="row profile-body">
    <!-- middle wrapper start -->
    @if (auth()->user()->level == 2)
    <div class="col-sm-12 col-md-5 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <form method="GET" action="">
                            <div style="display: flex; gap: 10px; align-items: center; margin-top: 10px;">
                                <select name="selected_suket" class="form-control w-full"
                                    onchange="this.form.submit()" style="flex: 1;">
                                    <option value="">–- Pilih Jenis Surat Keterangan –-</option>
                                    @foreach ($daftar_isi as $item)
                                    <option value="{{ $item['suket']->id_suket }}"
                                        {{ request('selected_suket') == $item['suket']->id_suket ? 'selected' : '' }}>
                                        {{ $item['suket']->nama_suket }} {{ $item['suket']->keperluan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <br>
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">TAMPILAN SURAT KETERANGAN YANG AKAN DIBUAT</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Tampilkan Surat Jika Sudah Dipilih --}}
                        @if (request('selected_suket'))
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td width="12%"><img
                                            src="{{ asset('assets/images/LogoKabupatenBrebes.png') }}"
                                            width="100%"></td>
                                    <td>
                                        <p
                                            style="font-family: 'Bookman Old Style', serif; font-size: 14pt; text-align: center; font-weight: bold;">
                                            PEMERINTAH KABUPATEN BREBES<br>
                                            DINAS KESEHATAN DAERAH<br>
                                            UNIT ORGANISASI BERSIFAT KHUSUS RSUD BREBES<br>
                                        </p>
                                        <p
                                            style="font-family: 'Bookman Old Style', serif; font-size: 7pt; text-align: center;">
                                            Jalan Jenderal Sudirman Nomor 181 Brebes Telepon (0283) 671431
                                            Faksimile
                                            (0283) 671095
                                        </p>
                                        <p
                                            style="font-family: 'Bookman Old Style', serif; font-size: 7pt; text-align: center;">
                                            Pos-el rsudbrebes@gmail.com
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr style="border: none; border-top: 4px solid black; margin: 0;">
                        <br>
                        @php
                        $suket = collect($daftar_isi)->firstWhere(
                        'suket.id_suket',
                        request('selected_suket'),
                        );
                        @endphp

                        @if ($suket)
                        {{-- ISI SURAT --}}
                        <p
                            style="font-family: 'Bookman Old Style', serif; font-size: 11pt; text-align: center; font-weight: bold;">
                            {{ $suket['suket']->nama_suket }}
                        </p>
                        <p
                            style="font-family: 'Bookman Old Style', serif; font-size: 11pt; text-align: center;">
                            Nomor : XXX/XXX/XXX/XXXX
                        </p>
                        <br>
                        <p style="font-family: 'Bookman Old Style', serif; font-size: 11pt;">
                            Yang bertanda tangan dibawah ini :
                        </p>

                        <table width="100%"
                            style="font-family: 'Bookman Old Style', serif; font-size: 11pt;">
                            <tbody>
                                <tr>
                                    <td width="30%">Nama Lengkap</td>
                                    <td>:</td>
                                    <td>Dr. dr. Rasipin, M.Kes, MARS</td>
                                </tr>
                                <tr>
                                    <td>NIP</td>
                                    <td>:</td>
                                    <td>19681125 200212 1 002</td>
                                </tr>
                                <tr>
                                    <td>Pangkat - Gol/Ruang</td>
                                    <td>:</td>
                                    <td>Pembina Utama Muda – IV/c</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>Direktur</td>
                                </tr>
                                <tr>
                                    <td>Unit Kerja</td>
                                    <td>:</td>
                                    <td>RSUD Brebes Kabupaten Brebes</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <p style="font-family: 'Bookman Old Style', serif; font-size: 11pt;">
                            Dengan ini menerangkan bahwa Saudara/i :
                        </p>
                        <table width="100%"
                            style="font-family: 'Bookman Old Style', serif; font-size: 11pt;">
                            <tbody>
                                <tr>
                                    <td width="30%">Nama Lengkap</td>
                                    <td>:</td>
                                    <td>
                                        @if (empty($pegawai->nama))
                                        <span
                                            style="color: red; font-weight: bold; background-color: #ffe6e6;">ANDA
                                            BELUM MELENGKAPI DATA !</span>
                                        @else
                                        {{ $pegawai->gelar_depan ? $pegawai->gelar_depan . '. ' : '' }}
                                        {{ Str::title(strtolower($pegawai->nama)) }}
                                        {{ $pegawai->gelar_belakang ? ', ' . $pegawai->gelar_belakang : '' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>NIP/NRP</td>
                                    <td>:</td>
                                    <td>
                                        @if (empty($pegawai->nip_nipppk_nrpk_nrpblud))
                                        <span
                                            style="color: red; font-weight: bold; background-color: #ffe6e6;">ANDA
                                            BELUM MELENGKAPI DATA !</span>
                                        @else
                                        {{ $pegawai->nip_nipppk_nrpk_nrpblud }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tempat, Tanggal Lahir</td>
                                    <td>:</td>
                                    <td>
                                        @if (empty($pegawai->tanggal_lahir))
                                        <span
                                            style="color: red; font-weight: bold; background-color: #ffe6e6;">ANDA
                                            BELUM MELENGKAPI DATA !</span>
                                        @else
                                        {{ Str::title(strtolower($pegawai->tempat_lahir)) }},
                                        {{ Carbon::parse($pegawai->tanggal_lahir)->translatedFormat('d F Y') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pendidikan</td>
                                    <td>:</td>
                                    <td>
                                        @if (empty($pendidikan->nama))
                                        <span
                                            style="color: red; font-weight: bold; background-color: #ffe6e6;">ANDA
                                            BELUM MELENGKAPI DATA !</span>
                                        @else
                                        {{ $pendidikan->nama }} {{ $pendidikan->jurusan }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>
                                        @if (empty($jabatan->nama))
                                        <span
                                            style="color: red; font-weight: bold; background-color: #ffe6e6;">ANDA
                                            BELUM MELENGKAPI DATA !</span>
                                        @else
                                        {{ $jabatan->nama }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Unit Kerja</td>
                                    <td>:</td>
                                    <td>RSUD Brebes Kabupaten Brebes</td>
                                </tr>
                            </tbody>
                        </table>

                        <br>
                        <p
                            style="font-family: 'Bookman Old Style', serif; font-size: 11pt; text-align: justify;">
                            {!! nl2br($suket['isi']) !!}
                        </p>
                        <br>
                        <p
                            style="font-family: 'Bookman Old Style', serif; font-size: 11pt; text-align: justify;">
                            Demikian surat keterangan ini dibuat dengan sesungguhnya dan sebenar-benarnya
                            untuk dapat digunakan sebagaimana mestinya.
                        </p>
                        <br>
                        <table width="100%"
                            style="font-family: 'Bookman Old Style', serif; font-size: 11pt; text-align: center;">
                            <tr>
                                <td width="50%"></td>
                                <td>Brebes, XX XX XXXX</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    Direktur RSUD Brebes<br><br><br><br>
                                    Dr. dr. Rasipin, M.Kes, MARS<br>
                                    NIP. 19681125 200212 1 002
                                </td>
                            </tr>
                        </table>
                        <br>
                        <form action="{{ route('persuratan.buat_suket.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="id_suket" value="{{ $suket['suket']->id_suket }}">
                            <input type="hidden" name="pegawai_id" value="{{ $pegawai->id }}">
                            <button style="width: 100%;" type="submit" class="btn btn-success"
                                {{ !$isLengkap ? 'disabled style=cursor:not-allowed;' : '' }}>
                                AJUKAN
                            </button>
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-7 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Daftar Pengajuan Surat Keterangan</h6>
                <div class="row">
                    <div class="col-sm-12 col-md-12 middle-wrapper">
                        <form method="GET" action="{{ url()->current() }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="cari" class="form-control"
                                    placeholder="Cari nama surat ...">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 middle-wrapper">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">NOMOR SURAT</th>
                                    <th class="text-center">NAMA SURAT</th>
                                    <th class="text-center">TANGGAL PENGAJUAN</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuan as $item)
                                <tr>
                                    <td style="font-size: 0.85em;">
                                        @if ($item->id_penomoran != null)
                                        {{ $item->kode . '/' . $item->nomor . '/' . $item->bulan . '/' . $item->tahun }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td style="font-size: 0.85em;">{{ $item->nama_suket }}
                                        {{ $item->keperluan }}
                                    </td>
                                    <td style="font-size: 0.85em;">
                                        {{ Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d-m-Y') }}
                                    </td>
                                    <td style="font-size: 0.85em;">
                                        @php
                                        $status = strtolower($item->status);
                                        @endphp

                                        @if ($status == 'diajukan')
                                        <span
                                            class="badge border border-primary text-primary">{{ ucfirst($status) }}</span>
                                        @elseif ($status == 'ditolak')
                                        <button type="button" class="badge bg-danger text-white border-0"
                                            data-bs-toggle="modal" data-bs-target="#keteranganModal"
                                            data-keterangan="{{ $item->keterangan }}">
                                            {{ ucfirst($status) }}
                                        </button>
                                        @elseif ($status == 'diproses')
                                        <span
                                            class="badge bg-warning text-dark">{{ ucfirst($status) }}</span>
                                        @elseif ($status == 'selesai')
                                        <span
                                            class="badge bg-success text-white">{{ ucfirst($status) }}</span>
                                        @else
                                        <span
                                            class="badge bg-secondary text-white">{{ ucfirst($status) }}</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 0.85em;" class="text-center">
                                        @php
                                        $status = strtolower($item->status);
                                        @endphp

                                        @if ($status == 'diajukan')
                                        <form
                                            onsubmit="return confirm('Apakah Anda yakin menghapus pengajuan {{ $item->nama_suket }} {{ $item->keperluan }} ini?');"
                                            action="{{ route('persuratan.buat_suket.destroy', $item->id_pengajuan) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs btn-icon">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </form>
                                        @elseif ($status == 'selesai')
                                        <a href="{{ route('persuratan.buat_suket.download', $item->id_pengajuan) }}"
                                            class="btn btn-success btn-xs btn-icon" data-bs-toggle="tooltip" title="Download">
                                            <i data-feather="download"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada pengajuan surat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pull-right mt-4">
                            <div class="pull-right mt-4">
                                {{ $pengajuan->withQueryString()->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- middle wrapper end -->
    </div>
    @else
    <div class="col-sm-12 col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Daftar Pengajuan Surat Keterangan</h6>
                <div class="row">
                    <div class="col-sm-12 col-md-12 middle-wrapper">
                        <form method="GET" action="{{ url()->current() }}">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="cari" class="form-control"
                                    placeholder="Cari nama surat ...">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 middle-wrapper">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">NOMOR SURAT</th>
                                    <th class="text-center">NAMA PEGAWAI</th>
                                    <th class="text-center">NAMA SURAT</th>
                                    <th class="text-center">TANGGAL PENGAJUAN</th>
                                    <th class="text-center">TANGGAL TERBIT</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuan as $item)
                                <tr>
                                    <td style="font-size: 0.85em;">
                                        @if ($item->id_penomoran != null)
                                        {{ $item->kode . '/' . $item->nomor . '/' . $item->bulan . '/' . $item->tahun }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td style="font-size: 0.85em;">
                                        {{ $item->gelar_depan ? $item->gelar_depan . '. ' : '' }}
                                        {{ Str::title(strtolower($item->nama)) }}
                                        {{ $item->gelar_belakang ? ', ' . $item->gelar_belakang : '' }}
                                    </td>
                                    <td style="font-size: 0.85em;">{{ $item->nama_suket }}
                                        {{ $item->keperluan }}
                                    </td>
                                    <td style="font-size: 0.85em;">
                                        {{ $item->tanggal_pengajuan ? Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d-m-Y') : '-' }}
                                    </td>
                                    <td style="font-size: 0.85em;">
                                        {{ $item->tanggal_terbit ? Carbon::parse($item->tanggal_terbit)->translatedFormat('d-m-Y') : '-' }}
                                    </td>
                                    <td style="font-size: 0.85em;">
                                        @php
                                        $status = strtolower($item->status);
                                        @endphp

                                        @if ($status == 'diajukan')
                                        <span
                                            class="badge border border-primary text-primary">{{ ucfirst($status) }}</span>
                                        @elseif ($status == 'ditolak')
                                        <button type="button" class="badge bg-danger text-white border-0"
                                            data-bs-toggle="modal" data-bs-target="#keteranganModal"
                                            data-keterangan="{{ $item->keterangan }}">
                                            {{ ucfirst($status) }}
                                        </button>
                                        @elseif ($status == 'diproses')
                                        <span
                                            class="badge bg-warning text-dark">{{ ucfirst($status) }}</span>
                                        @elseif ($status == 'selesai')
                                        <span
                                            class="badge bg-success text-white">{{ ucfirst($status) }}</span>
                                        @else
                                        <span
                                            class="badge bg-secondary text-white">{{ ucfirst($status) }}</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 0.85em;" class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            @php
                                            $status = strtolower($item->status);
                                            @endphp

                                            @if ($status == 'diajukan')
                                            {{-- Tombol Lihat --}}
                                            <button class="btn btn-default btn-xs btn-icon"
                                                data-bs-toggle="tooltip" title="Lihat"
                                                onclick="previewSurat(this)"
                                                data-id="{{ $item->id_pengajuan }}">
                                                <i data-feather="eye"></i>
                                            </button>

                                            {{-- Tombol Tolak --}}
                                            <button class="btn btn-danger btn-xs btn-icon"
                                                data-bs-toggle="tooltip" title="Tolak"
                                                onclick="showTolakModal('{{ $item->id_pengajuan }}')">
                                                <i data-feather="delete"></i>
                                            </button>
                                            @elseif ($status == 'diproses')
                                            @if ($item->tanggal_terbit)
                                            {{-- Tombol Cetak --}}
                                            <a href="{{ route('buat_suket.cetak', $item->id_pengajuan) }}?redirect=1"
                                                class="btn btn-primary btn-xs btn-icon"
                                                title="Cetak">
                                                <i data-feather="printer"></i>
                                            </a>

                                            {{-- Tombol Upload --}}
                                            <button class="btn btn-success btn-xs btn-icon"
                                                data-bs-toggle="modal" data-bs-target="#uploadModal"
                                                onclick="setUploadId('{{ $item->id_pengajuan }}')"
                                                title="Upload">
                                                <i data-feather="upload"></i>
                                            </button>
                                            @else
                                            {{-- Tombol Lihat --}}
                                            <button class="btn btn-default btn-xs btn-icon"
                                                data-bs-toggle="tooltip" title="Lihat"
                                                onclick="previewSurat(this)"
                                                data-id="{{ $item->id_pengajuan }}">
                                                <i data-feather="eye"></i>
                                            </button>

                                            {{-- Tombol Upload --}}
                                            <button class="btn btn-success btn-xs btn-icon"
                                                data-bs-toggle="modal" data-bs-target="#uploadModal"
                                                onclick="setUploadId('{{ $item->id_pengajuan }}')"
                                                title="Upload">
                                                <i data-feather="upload"></i>
                                            </button>
                                            @endif
                                            @elseif ($status == 'selesai')
                                            {{-- Tombol Download --}}
                                            <a href="{{ route('persuratan.buat_suket.download', $item->id_pengajuan) }}"
                                                class="btn btn-success btn-xs btn-icon" title="Download">
                                                <i data-feather="download"></i>
                                            </a>
                                            @elseif ($status == 'ditolak')
                                            {{-- Tidak tampilkan tombol apapun --}}
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada pengajuan
                                        surat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pull-right mt-4">
                            <div class="pull-right mt-4">
                                {{ $pengajuan->withQueryString()->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- middle wrapper end -->
    </div>
    @endif
    <div class="modal fade" id="lihatSuket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TAMPILAN SURAT KETERANGAN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="btn-close"></button>
                </div>
                <div class="modal-body" id="modalSuketBody">
                    <div class="text-center">Memuat surat...</div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tolakSuket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ALASAN PENOLAKAN SURAT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTolak" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_suket" id="idSuketTolak">
                        <div class="mb-3">
                            <textarea name="keterangan" class="form-control" required></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                            <button type="submit" class="btn btn-success">SIMPAN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="keteranganModal" tabindex="-1" aria-labelledby="keteranganModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alasan Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" id="isiKeteranganModal">
                    Memuat...
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content bg-white rounded shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">UPLOAD FILE SURAT KETERANGAN</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_suket" id="uploadIdSuket">
                        <div class="mb-3">
                            <label class="form-label">Pilih File (PDF Maks. 2MB)</label>
                            <input type="file" class="form-control" name="file" accept="application/pdf"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (feather) feather.replace();

            window.previewSurat = function(btn) {
                const idSuket = btn.getAttribute('data-id');
                console.log("Preview Surat ID:", idSuket); // DEBUG

                fetch(`/persuratan/buat_suket/preview/${idSuket}`)
                    .then(res => {
                        if (!res.ok) throw new Error(`HTTP error ${res.status}`);
                        return res.text();
                    })
                    .then(html => {
                        console.log("Isi HTML:", html); // DEBUG
                        document.getElementById('modalSuketBody').innerHTML = html;
                        const modal = new bootstrap.Modal(document.getElementById('lihatSuket'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error("Gagal memuat surat:", error);
                        document.getElementById('modalSuketBody').innerHTML =
                            `<div class="text-danger">Gagal memuat surat: ${error.message}</div>`;
                    });
            };
        });
    </script>

    <script>
        function showTolakModal(id = null) {
            if (id) {
                const form = document.getElementById('formTolak');
                form.action = `/persuratan/buat_suket/update/${id}`;
                document.getElementById('idSuketTolak').value = id;
            }
            const modal = new bootstrap.Modal(document.getElementById('tolakSuket'));
            modal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const keteranganModal = document.getElementById('keteranganModal');
            keteranganModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const keterangan = button.getAttribute('data-keterangan');
                const modalBody = keteranganModal.querySelector('#isiKeteranganModal');
                modalBody.textContent = keterangan || 'Tidak ada keterangan.';
            });
        });
    </script>

    <script>
        function setUploadId(id) {
            document.getElementById('uploadIdSuket').value = id;

            const form = document.getElementById('uploadForm');
            form.action = `/persuratan/buat_suket/upload/${id}`;
        }
    </script>

    @endsection

    @push('plugin-scripts')
    <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    @endpush

    @push('custom-scripts')
    <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    @endpush