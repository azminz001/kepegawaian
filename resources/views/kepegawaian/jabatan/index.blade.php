@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item active" aria-current="page">Jabatan Pegawai</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Jabatan Pegawai</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Jabatan Baru</h6>
                <form action="{{route('jabatan.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" placeholder="Nama Unit">
                        @error('nama')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Status Kesehatan</label>
                        <select class="form-control" name="status_kesehatan">
                            <option>- Pilih Status Kesehatan -</option>
                            <option value="KESEHATAN">KESEHATAN</option>
                            <option value="NON KES">NON KESEHATAN</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Status Medis</label>
                        <select class="form-control" name="status_medis">
                            <option>- Pilih Status Medis -</option>
                            <option value="MEDIS">MEDIS</option>
                            <option value="NON MEDIS">NON MEDIS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Status Perawat</label>
                        <select class="form-control" name="status_perawatan">
                            <option>- Pilih Status Perawat -</option>
                            <option value="PERAWATAN">PERAWAT</option>
                            <option value="NON PERAWATAN">NON PERAWAT</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-8 middle-wrapper">
        <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card rounded">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ms-2">
                    <h6 class="card-title mb-0">Daftar Jabatan Unit RSUD Brebes</h6>            
                    </div>
                </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('jabatan.cari') }}">
                    @csrf
                    <div class="input-group">
                        <div class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Jabatan Pegawai">
                        <button type="submit" class="btn btn-secondary">Cari</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th class="text-center">Kesehatan</th>
                                <th class="text-center">Medis</th>
                                <th class="text-center">Perawat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jabatans as $key => $jabatan)
                                <tr>
                                    <td scope="row">{{ $key + $jabatans->firstItem() }}</td>
                                    <td>
                                        <a href="{{url('kepegawaian/jabatan/'.$jabatan->id)}}">
                                            {{$jabatan->nama}}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $color = "";
                                            $icon  = "";
                                            if($jabatan->status_kesehatan == "KESEHATAN"){
                                                $warna = "success";
                                                $icon = "check";
                                            }elseif($jabatan->status_kesehatan == "NON KES"){
                                                $warna = "danger";
                                                $icon = "x";
                                            }
                                        ?>
                                        <span data-feather="{{$icon}}-circle" class="text-{{$warna}}"></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $color = "";
                                            $icon  = "";
                                            if($jabatan->status_medis == "MEDIS"){
                                                $warna = "success";
                                                $icon = "check";
                                            }elseif($jabatan->status_medis == "NON MEDIS"){
                                                $warna = "danger";
                                                $icon = "x";
                                            }
                                        ?>
                                        <span data-feather="{{$icon}}-circle" class="text-{{$warna}}"></span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            $warna = "";
                                            $icon  = "";
                                            if($jabatan->status_perawatan == "PERAWATAN"){
                                                $warna = "success";
                                                $icon = "check";
                                            }elseif($jabatan->status_perawatan == "NON PERAWATAN"){
                                                $warna = "danger";
                                                $icon = "x";
                                            }
                                            
                                        ?>
                                        <span data-feather="{{$icon}}-circle" class="text-{{$warna}}"></span>
                                    </td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin mengahapus unit {{$jabatan->nama}}?');" action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST">
                                            <button type="button" class="btn btn-primary btn-xs btn-icon"  data-bs-toggle="modal" data-bs-target="#editUnit{{$jabatan->id}}">
                                                <i data-feather="edit"></i>
                                            </button>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-xs btn-icon">
                                                <i data-feather="trash-2"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pull-right mt-4">
                      <ul class="pagination justify-content-center">
                        {{ $jabatans->onEachSide(0)->links('pagination::bootstrap-4') }}
                      </ul>
                    </div>
                    <small>Menampilkan {{$jabatans->count()}} data dari total {{$jabatan_count}} Jabatan.</small>

                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>
@foreach ($jabatans as $jabatan)
<div class="modal fade" id="editUnit{{$jabatan->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('jabatan.update', $jabatan->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$jabatan->nama}}" placeholder="Nama Unit">
                        @error('nama')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Status Kesehatan</label>
                        <select class="form-control" name="status_kesehatan">
                            <option value="{{$jabatan->status_kesehatan}}">{{$jabatan->status_kesehatan}}</option>
                            <option value="KESEHATAN">KESEHATAN</option>
                            <option value="NON KES">NON KES</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Status Medis</label>
                        <select class="form-control" name="status_medis">
                            <option value="{{$jabatan->status_medis}}">{{$jabatan->status_medis}}</option>
                            <option value="MEDIS">MEDIS</option>
                            <option value="NON MEDIS">NON MEDIS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Status Perawat</label>
                        <select class="form-control" name="status_perawatan">
                            <option value="{{$jabatan->status_perawatan}}">{{$jabatan->status_perawatan}}</option>
                            <option value="PERAWATAN">PERAWAT</option>
                            <option value="NON PERAWATAN">NON PERAWAT</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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