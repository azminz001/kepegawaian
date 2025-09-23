@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item active" aria-current="page">Jabatan Unit</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Jabatan Unit</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Jabatan Unit Baru</h6>
                <form action="{{route('jabatan_unit.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" placeholder="Nama Unit">
                        @error('nama')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Jenis Jabatan</label>
                        <select class="form-control" name="jenis_jabatan_id">
                            @foreach ($jenis_jabatans as $jenis_jabatan)
                                <option value="{{$jenis_jabatan->id}}">{{$jenis_jabatan->nama}}</option>
                            @endforeach
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
                        <form action="{{ route('jabatan_unit.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Jabatan Unit">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jenis Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jabatan_units as $key => $unit)
                                        <tr>
                                            <td scope="row">{{ $key + $jabatan_units->firstItem() }}</td>
                                            <td>
                                                <a href="{{url('kepegawaian/jabatan_unit/'.$unit->id)}}">
                                                    {{$unit->nama}}
                                                </a>
                                            </td>
                                            <td>
                                                @if ($unit->jenis_jabatan)
                                                    {{ $unit->jenis_jabatan->nama }}
                                                @else
                                                    Jenis jabatan belum diatur
                                                @endif
                                            </td>
                                            <td>
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus unit {{$unit->nama}}?');" action="{{ route('jabatan_unit.destroy', $unit->id) }}" method="POST">
                                                    <button type="button" class="btn btn-primary btn-xs btn-icon"  data-bs-toggle="modal" data-bs-target="#editUnit{{$unit->id}}">
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
                                {{ $jabatan_units->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>
                            <small>Menampilkan {{$jabatan_units->count()}} data dari total {{$jabatan_unit_count}} Jabatan Unit.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>
@foreach ($jabatan_units as $unit)
<div class="modal fade" id="editUnit{{$unit->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('jabatan_unit.update', $unit->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$unit->nama}}" placeholder="Nama Unit">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Jenis Jabatan</label>
                        <select class="form-control" name="jenis_jabatan_id">
                                <option value="{{$unit->jenis_jabatan_id}}">- Ganti Jenis Jabatan -</option>
                            @foreach ($jenis_jabatans as $jenis_jabatan)
                                <option value="{{$jenis_jabatan->id}}">{{$jenis_jabatan->nama}}</option>
                            @endforeach
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