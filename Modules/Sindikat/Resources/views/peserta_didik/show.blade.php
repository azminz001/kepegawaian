@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />


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
<div class="row">
<div class="col-12 grid-margin">
    <div class="card">
    <div class="position-relative" style="background-color: rgba(0, 0, 0, 0.5)">
        <figure class="overflow-hidden mb-0 d-flex justify-content-center">
        <img src="{{ url('/assets/images/rsud_landscape.jpg') }}"class="rounded-top img-fluid" alt="profile cover" style="filter: brightness(70%)">
        </figure>
        <div class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
        <div>
            @if ($student->jenis_kelamin == 0)
            <img class="wd-70 rounded-circle" src="{{ url('/assets/images/student_male.png') }}" style="background-color: #fff" alt="profile">
            @else
            <img class="wd-70 rounded-circle" src="{{ url('/assets/images/student_female.png') }}" style="background-color: #fff" alt="profile">
            @endif
            <span class="h4 ms-3 text-white">{{$student->nama_lengkap}}</span>
        </div>
        {{-- <div class="d-none d-md-block">
            <button class="btn btn-primary btn-icon-text">
            <i data-feather="edit" class="btn-icon-prepend"></i> Edit profile
            </button>
        </div> --}}
        </div>
    </div>
    <div class="d-flex justify-content-center p-3 rounded-bottom">
        <h5 class="text-primary">
            PROFIL DATA PESERTA MAGANG
        </h5>
    </div>
    </div>
</div>
</div>
<div class="row profile-body">
<!-- left wrapper start -->
<div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
    <div class="card rounded">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="card-title mb-0">DATA DIRI</h6>
                <div class="dropdown">
                    <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Ubah Data</span></a>
                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Hapus Data</span></a>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Nama:</label>
                <p class="text-muted">{{$student->nama_lengkap}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Nomor Induk:</label>
                <p class="text-muted">{{$student->no_induk}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Jenis Kelamin:</label>
                <p class="text-muted">{{$student->jenis_kelamin ? 'Laki-Laki': 'Perempuan'}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Jurusan:</label>
                <p class="text-muted">{{$student->jurusan->nama}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Perguruan Tinggi/Sekolah:</label>
                <p class="text-muted">{{$student->jurusan->institusi->nama}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Kota:</label>
                <p class="text-muted">{{$student->jurusan->institusi->kota}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Periode Magang:</label>
                <p class="text-muted">{{date_format(date_create($student->permohonan_magang->tanggal_mulai), 'd F Y')}} s.d {{date_format(date_create($student->permohonan_magang->tanggal_selesai), 'd F Y')}}</p>
            </div>
        </div>
    </div>
</div>
<!-- left wrapper end -->
<!-- middle wrapper start -->
<div class="col-md-8 col-xl-5 middle-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card rounded">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="card-title mb-0">Jadwal Ruang Peserta Magang RSUD Brebes</h6>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('sindikat.jadwal_peserta_didik.store')}}" method="post">
                    @csrf
                        <div class="row">
                            <div class="col-md-12 col-sm-12 mb-3">
                                <label for="">Unit Kerja</label>
                                <input type="hidden" name="peserta_didik_id" value="{{$student->id}}">
                                <select class="js-example-basic-single form-select" name="unit_id" data-width="100%">
                                    <option disabled selected value>Pilih Unit Kerja</option>
                                    @foreach ($units as $unit)
                                        <option value="{{$unit->id}}">{{$unit->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="">Tanggal Mulai</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_mulai" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="">Tanggal Selesai</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_selesai" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success"><span class="mdi mdi-calendar-plus mx-2"></span>Jadwal Baru</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">

            <div class="card rounded">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="card-title mb-0">Jadwal Ruang {{$student->nama_lengkap}}</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Unit Kerja</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $jadwal)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            {{date_format(date_create($jadwal->tanggal_mulai), 'd F Y')}} s.d {{date_format(date_create($jadwal->tanggal_selesai), 'd F Y')}} <br>
                                            <strong>{{$jadwal->unit->nama}}</strong>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-xs btn-warning"><span class="mdi mdi-pencil"></span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- middle wrapper end -->
<!-- right wrapper start -->
<div class="d-none d-xl-block col-xl-4">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card rounded">
            <div class="card-body">
                <h6 class="card-title">Evaluasi Peserta Magang</h6>
                <div class="row ms-0 me-0">
                    @if ($student->evaluasi->isEmpty())
                        <form action="{{route('sindikat.evaluasi_peserta.store', $student->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="permohonan_magang_id" value="{{$student->permohonan_magang->id}}">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">Catatan Instruktur*</label>
                                <textarea name="catatan" class="form-control" id="" cols="30" rows="5"></textarea>
                                @error('catatan')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Form Evaluasi</label>
                                <input type="file" name="dokumen" class="form-control" id="myDropify" aria-describedby="fileHelpId">
                                 @error('dokumen')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                            <button class="btn btn-sm btn-success">Simpan</button>
                        </form>
                    @else
                        <div class="alert alert-primary" role="alert">
                            <p>Instruktur Klinis telah upload evaluasi peserta didik</p>

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td scope="row"> Nama Instruktur <br><strong>{{optional($student->evaluasi->first())->pegawai->nama}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Catatan Instruktur <br>{{$student->evaluasi->first()->catatan}}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data ini?');" action="{{route('sindikat.evaluasi_peserta.destroy', $student->evaluasi->first()->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{asset('storage/sindikat/evaluasi_peserta/'.$student->evaluasi->first()->dokumen)}}" target="blank" class="btn btn-sm btn-success">Buka Dokumen</a>
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- right wrapper end -->
</div>
@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
  @endpush
  
  @push('custom-scripts')
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>