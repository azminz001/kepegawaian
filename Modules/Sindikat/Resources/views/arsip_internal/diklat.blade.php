@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item active" aria-current="page">Arsip Diklat Pegawai</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Arsip Diklat</h3>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0 text-white">Total Arsip Diklat</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2 mt-3 text-white">{{$total_arsip_diklat}}</h3>
                                <div class="d-flex align-items-baseline">
                                <p class="text-white">
                                    <span>Sertifikat</span>
                                </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <p style="font-size: 32pt" align="right"><i class="mdi mdi-certificate text-white"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0 text-white">Total Arsip Diklat Tahun {{date('Y')}}</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2 mt-3 text-white">{{$diklat_count->year_current}}</h3>
                                <div class="d-flex align-items-baseline">
                                <p class="text-white">
                                    <span>Sertifikat</span>
                                </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <p style="font-size: 32pt" align="right"><i class="mdi mdi-certificate text-white"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Arsip Diklat Tahun {{date('Y') - 1}}</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2 mt-3">{{$diklat_count->year_previous}}</h3>
                                <div class="d-flex align-items-baseline">
                                <p class="">
                                    <span>Sertifikat</span>
                                </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <p style="font-size: 32pt" align="right"><i class="mdi mdi-certificate"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <h6 class="card-title mb-0">Total Arsip Diklat Tahun {{date('Y') - 2}}</h6>
                        </div>
                        <div class="row">
                            <div class="col-6 col-md-12 col-xl-5">
                                <h3 class="mb-2 mt-3">{{$diklat_count->year_two_years_ago}}</h3>
                                <div class="d-flex align-items-baseline">
                                <p class="">
                                    <span>Sertifikat</span>
                                </p>
                                </div>
                            </div>
                            <div class="col-6 col-md-12 col-xl-7">
                                <p style="font-size: 32pt" align="right"><i class="mdi mdi-certificate"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row profile-body">
    <!-- middle wrapper start -->

    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex justify-content-between flex-column flex-md-row">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0">Data Diklat Pegawai Terbaru</h6>            
                                </div>
                            </div>
                            {{-- <div class="mt-3 mt-md-0">
                                <button class="btn btn-success btn-icon-text" data-bs-toggle="modal" data-bs-target="#createPegawai"><i class="btn-icon-prepend" data-feather="user-plus"></i>Tambah Pegawai Baru</button>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sindikat.arsip_diklat.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="btn-icon-prepend" data-feather="search"></i>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Nama atau Nomor Induk Pegawai">
                                <button type="submit" class="btn btn-secondary btn-icon-text" style="margin-right: 14px">Cari</button>
                                <a href="{{route('sindikat.arsip_diklat.export')}}" class="btn btn-success btn-icon-text"> <i class="mdi mdi-file-excel mx-2"></i> Unduh Excel
                                </a>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th class="text-center">Pend. Terakhir</th>
                                        <th class="text-center">Diklat yang Diikuti</th>
                                        <th class="text-center">Tanggal Pelatihan</th>
                                        <th class="text-center">Penyelenggara Pelatihan</th>
                                        <th class="text-center">Tempat</th>
                                        <th class="text-center">Sertifikat</th>
                                        <th class="text-center">Masa Berlaku</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($diklats as $key => $diklat)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em">{{ $key + $diklats->firstItem() }}</td>
                                            <td style="font-size: 0.85em;">
                                                {{-- <a href="{{url('kepegawaian/data_pegawai/show/'.$diklat->pegawai->id)}}"> --}}
                                                    {{($diklat->pegawai->gelar_depan!=null)? $diklat->pegawai->gelar_depan.". ":""}}{{$diklat->pegawai->nama}}{{($diklat->pegawai->gelar_belakang!=null)?", ".$diklat->pegawai->gelar_belakang:""}}
                                                {{-- </a><br> --}}<br />
                                                <small class="text-muted">
                                                    @if ($diklat->pegawai->status_kepegawaian == 'PNS')
                                                        NIP.
                                                    @elseif ($diklat->pegawai->status_kepegawaian == 'PPPK')
                                                        NIPPPK. 
                                                    @elseif ($diklat->pegawai->status_kepegawaian == 'KONTRAK')
                                                        NRPK.
                                                    @elseif($diklat->pegawai->status_kepegawaian == 'BLUD' || $diklat->pegawai->status_kepegawaian == 'MITRA')
                                                        NRPBLUD.
                                                    @else
                                                    NIP/ NIPPPK/ NRPK/ NRPBLUD.
                                                    @endif
                                                    {{$diklat->pegawai->nip_nipppk_nrpk_nrpblud}}
                                                </small><br />
                                                {{isset($diklat->pegawai->unit_jabatan_aktif->nama_unit) ? strtoupper($diklat->pegawai->unit_jabatan_aktif->nama_jabatan_unit)." DI ".$diklat->pegawai->unit_jabatan_aktif->nama_unit:"Belum Atur Jabatan Unit Pegawai"}}
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                @if (isset($diklat->pegawai->pendidikan_terakhir))
                                                {{$diklat->pegawai->pendidikan_terakhir->nama}} - {{$diklat->pegawai->pendidikan_terakhir->jurusan}}
                                                @else
                                                Belum atur Pendidikan Terakhir
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$diklat->nama_diklat}}
                                            </td>
                                            <td style="font-size: 0.85em">
                                                @if ($diklat->tanggal_selesai != null)
                                                    {{date('d-M-Y', strtotime($diklat->tanggal_mulai))}} s.d {{date('d-M-Y', strtotime($diklat->tanggal_selesai))}}
                                                @else
                                                    {{date('d-M-Y', strtotime($diklat->tanggal_mulai))}} 
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$diklat->institusi_penyelenggara}}
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$diklat->tempat}}
                                            </td style="font-size: 0.85em">
                                            <td class="text-center">
                                                <a href="{{ asset('storage/dokumen_pegawai/'.$diklat->pegawai->id.'/'.$diklat->dokumen_sertifikat) }}" target="blank" class="btn btn-primary btn-xs">Buka</a>
                                            </td>
                                            <td class="text-center"  style="font-size: 0.85em">
                                                {{$diklat->masa_berlaku}}
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $diklats->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>

@endpush