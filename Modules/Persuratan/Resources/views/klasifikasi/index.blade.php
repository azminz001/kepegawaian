@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Persuratan</li>
        <li class="breadcrumb-item active" aria-current="page">Klasifikasi Surat</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Klasifikasi Surat</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">TAMBAH KLASIFIKASI SURAT BARU</h6>
                <form action="{{route('persuratan.klasifikasi.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Kode Klasifikasi *</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="kode" placeholder="masukan kode klasifikasi surat" required>
                        @error('kode')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Klasifikasi *</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" placeholder="masukan nama klasifikasi surat" required>
                        @error('nama')
                            <code>{{$message}}</code>
                        @enderror
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
                    <h6 class="card-title mb-0">DAFTAR KLASIFIKASI SURAT RSUD BREBES</h6>            
                    </div>
                </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('persuratan.klasifikasi.cari') }}">
                    @csrf
                    <div class="input-group">
                        <div class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        </div>
                        <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="cari klasifikasi surat">
                        <button type="submit" class="btn btn-secondary">Cari</button>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">KODE KLASIFIKASI</th>
                                <th class="text-center">NAMA KLASIFIKASI</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($klasifikasi as $key => $klas)
                                <tr>
                                    <td>{{$klas->kode}}</td>
                                    <td>{{$klas->nama}}</td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin mengahapus klasifikasi {{$klas->nama}}?');" action="{{ route('persuratan.klasifikasi.destroy', $klas->id) }}" method="POST">
                                            <button type="button" class="btn btn-primary btn-xs btn-icon"  data-bs-toggle="modal" data-bs-target="#editKlasifikasi{{$klas->id}}">
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
                        {{ $klasifikasi->onEachSide(0)->links('pagination::bootstrap-4') }}
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
@foreach ($klasifikasi as $klas)
<div class="modal fade" id="editKlasifikasi{{$klas->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('persuratan.klasifikasi.update', $klas->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Kode Klasifikasi *</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="kode" value="{{$klas->kode}}" placeholder="masukkan kode klasifikasi" required>
                        @error('kode')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Klasifikasi</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$klas->nama}}" placeholder="masukkan nama klasifikasi" required>
                        @error('nama')
                            <code>{{$message}}</code>
                        @enderror
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