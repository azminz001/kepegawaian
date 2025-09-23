@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endpush
<style>
    .select2-container--open {
        z-index: 9999999;
    }
    .modal-open .select2-container--open {
        z-index: 9999999;
    }
</style>

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item" aria-current="page">Institusi</li>
        <li class="breadcrumb-item active" aria-current="page">Permohonan Co-Ass/PKL/Magang</li>
    </ol>
</nav>
<h4 class="page-title mb-4">Detail Permohonan Co-Ass/PKL/Magang</h4> 
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-3 grid-margin">
        @include('sindikat::institusi.sidebarprofil')
    </div>
    <div class="col-sm-12 col-md-9 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0"><i class="mdi mdi-account-box-outline icon-lg mx-2"></i> Data Permohonan</h6>     
                                </div>
                            </div>
                            {{-- <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createStudent">Tambah Peserta Didik</a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. Surat</label>
                                    <input type="text" class="form-control" name="no_surat" value="{{$magang->no_surat}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Surat</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_surat" value="{{date_format(date_create($magang->tanggal_surat), 'd-M-Y')}}" disabled>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Mulai Magang</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_mulai" value="{{date_format(date_create($magang->tanggal_mulai), 'd-M-Y')}}" disabled>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Selesai Magang</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_selesai" value="{{date_format(date_create($magang->tanggal_selesai), 'd-M-Y')}}" disabled>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jumlah Peserta</label>
                                    {{-- {{$magang->peserta_didik->count()}} --}}
                                    @if ($magang->peserta_didik->count() == $magang->jumlah_peserta)
                                        <input type="text" class="form-control" name="jumlah_peserta"  value="{{$magang->jumlah_peserta}} peserta" disabled>
                                    @else
                                        <input type="text" class="form-control" name="jumlah_peserta"  value="{{$magang->peserta_didik->count()}} dari {{$magang->jumlah_peserta}} peserta diusulkan" disabled>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Dokumen Permohonan</label>
                                    <p>
                                        <button class="btn btn-sm btn-primary form-control" data-bs-toggle="modal" data-bs-target="#openDoc">Buka Dokumen</button>
                                    </p>
                                </div>
                            </div>
                            @php
                                $color = "";
                                $message = "";
                                if ($magang->status == 0) {
                                    $color = "primary";
                                    $message = "Permohonan Diajukan";
                                }elseif ($magang->status == 1) {
                                    $color = "success";
                                    $message = "Berkas Diterima";
                                }elseif ($magang->status == 2) {
                                    $color = "warning";
                                    $message = "Permohonan Dikoordinasikan";
                                }elseif ($magang->status == 3) {
                                    $color = "primary";
                                    $message = "Dalam Proses";
                                }elseif ($magang->status == 4) {
                                    $color = "success";
                                    $message = "Permohonan Disetujui";
                                }elseif ($magang->status == 5) {
                                    $color = "danger";
                                    $message = "Permohonan Ditolak";
                                }
                            @endphp
                            @if (Auth::user()->level == 4 || Auth::user()->level == 0)
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status Permohonan: <span class="badge bg-{{$color}}">{{$message}}</span></label>
                                    <form action="{{route('sindikat.permohonan_magang.konfirmasi', $magang->id)}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group">
                                            <select name="status" class="form-control" id="">
                                                <option disabled selected value>- Perbarui Status Permohonan -</option>
                                                <option value="0">Permohonan Diajukan</option>
                                                <option value="1">Berkas Diterima</option>
                                                <option value="2">Permohonan Dikoordinasikan</option>
                                                <option value="3">Dalam Proses</option>
                                                <option value="4">Permohonan Disetujui</option>
                                                <option value="5">Permohonan Ditolak</option>
                                            </select>
                                            <button type="submit" class="btn btn-warning btn-icon-text" style="margin-right: 14px">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @else
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status Permohonan: </label>
                                    <button type="button" class="btn btn-{{$color}} btn-icon-text" style="margin-right: 14px">{{$message}}</button>
                                </div>
                            </div>
                            @endif
                            <h5 class="mt-2">Usulkan Data Peserta Co-Ass/PKL/Magang</h5>
                            <div class="table-responsive mt-2">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">No</th>
                                            <th class="text-center">Nomor Induk</th>
                                            <th class="text-center">Nama Peserta</th>
                                            <th class="text-center">Jenis Kelamin</th>
                                            <th class="text-center">Jurusan</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                        <tr>
                                            <form action="{{route('sindikat.peserta_didik.store')}}" method="post">
                                                @csrf
                                                <td class="bg-success text-center text-light" valign="middle"><span class="" data-feather="plus-circle"></span><input type="hidden" name="permohonan_magang_id" value="{{$magang->id}}"><input type="hidden" name="institusi_id" value="{{$magang->institusi->id}}"></td>
                                                <td><input type="text" name="no_induk" class="form-control form-control-sm" id="" placeholder="NIM/NIS/NISN" required></td>
                                                <td><input type="text" name="nama_lengkap" class="form-control form-control-sm" id="" placeholder="Nama Lengkap" required></td>
                                                <td>
                                                    <select name="jenis_kelamin" class="form-control form-select-sm" id="" required>
                                                        <option disabled selected value>- Pilih Jenis Kelamin -</option>
                                                        <option value="0">Laki-Laki</option>
                                                        <option value="1">Perempuan</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="jurusan_id" class="form-control form-select-sm" id="" required>
                                                        <option disabled selected value>- Pilih Jurusan -</option>
                                                        @foreach ($majors as $major)
                                                            <option value="{{$major->id}}">{{$major->nama}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-success">Tambahkan</button>
                                                </td>
                                            </form>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($students as $key => $student)
                                            <tr>
                                                <td style="font-size: 0.85em;">{{$key + 1}}</td>
                                                <td style="font-size: 0.85em;">{{$student->no_induk}}</td>
                                                <td style="font-size: 0.85em;">{{$student->nama_lengkap}}</td>
                                                <td style="font-size: 0.85em;">{{$student->jenis_kelamin == 0 ? 'Laki-Laki':'Perempuan'}}</td>
                                                <td style="font-size: 0.85em;">{{$student->jurusan->nama}}</td>
                                                <td class="text-center">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin mengahapus peserta ini?');" action="{{ route('sindikat.peserta_didik.destroy', $student->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-xs btn-icon">
                                                            <i data-feather="trash-2"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" style="font-size: 0.85em;"><p class="text-danger">Belum ada peserta yang ditambahkan</p></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>

{{-- <div class="modal fade" id="createStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Peserta Didik Co-Ass</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('sindikat.jurusan.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="institusi_id" value="{{$magang->id}}">


                        </div>
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}


<div class="modal fade" id="openDoc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Dokumen Surat Permohonan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    {{$magang->institusi_id.'/'.$magang->dokumen}}
                    <div class="row">
                        <iframe src="{{ asset('storage/sindikat/permohonan_magang/'.$magang->institusi_id.'/'.$magang->dokumen) }}" type="application/pdf" width="100%" height="720px"></iframe>
                    </div>
                </div>
                <button type="submit" class="btn btn-secondary mt-3" data-bs-dismiss="modal" aria-label="btn-close">Tutup</button>
            </div>
        </div>
    </div>
</div>

@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>


@endpush
