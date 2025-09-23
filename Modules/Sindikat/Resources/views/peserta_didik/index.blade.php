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
<h3 class="page-title mb-2">Data Arsip Diklat Terbaru</h3>
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
                                    <h6 class="card-title mb-0">Data Diklat Pegawai</h6>            
                                </div>
                            </div>
                            {{-- <div class="mt-3 mt-md-0">
                                <button class="btn btn-success btn-icon-text" data-bs-toggle="modal" data-bs-target="#createPegawai"><i class="btn-icon-prepend" data-feather="user-plus"></i>Tambah Pegawai Baru</button>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sindikat.peserta_didik.cari') }}"  method="POST">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="btn-icon-prepend" data-feather="search"></i>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Nama atau No. Induk Peserta Magang">
                                <button type="submit" class="btn btn-secondary btn-icon-text" style="margin-right: 14px">Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            @if ($pegawai_ci)
                            {{-- {{dd($students)}} --}}
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th colspan="2">Nama</th>
                                        <th>No. Induk</th>
                                        <th>Institusi</th>
                                        <th>Periode Magang</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($students as $key => $student)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em">{{ $key + $students->firstItem()}}</td>
                                            <td  style="font-size: 0.85em">{{$student->nama_lengkap}}</td>
                                            <td  style="font-size: 0.85em"><span class="mdi mdi-gender-{{$student->jenis_kelamin == 0 ? 'male':'female'}}"></span></td>
                                            <td  style="font-size: 0.85em">{{$student->no_induk}}</td>
                                            <td  style="font-size: 0.85em">
                                                <strong>{{$student->jurusan->institusi->nama}}</strong><br>
                                                {{$student->jurusan->nama}}
                                            </td>
                                            
                                            <td  style="font-size: 0.85em">
                                                {{date('d-M-Y', strtotime($student->permohonan_magang->tanggal_mulai))}} s.d {{date('d-M-Y', strtotime($student->permohonan_magang->tanggal_selesai))}}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('sindikat.peserta_didik.show', $student->id)}}" class="btn btn-xs btn-success">Evaluasi</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">Tidak ada Peserta Didik Magang</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $students->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>
                                
                            @else
                            
                            <div class="alert alert-primary mt-3" role="alert">
                                <strong>Informasi!</strong>
                                <p>Pastikan bahwa Anda memiliki status Instruktur Klinik Aktif, Buka Menu <strong>Riwayat Instruktur Klinik</strong>.</p>
                            </div>
                            @endif

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