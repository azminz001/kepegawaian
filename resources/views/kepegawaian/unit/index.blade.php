@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item active" aria-current="page">Unit</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Unit</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Unit Baru</h6>
                <form action="{{route('unit.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" placeholder="Nama Unit">
                        @error('nama')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="" cols="30" rows="10"></textarea>
                        @error('keterangan')
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
                    <h6 class="card-title mb-0">Daftar Unit RSUD Brebes</h6>            
                    </div>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTableExample">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($units as $key => $unit)
                                <tr>
                                    <td scope="row">{{$key+1}}</td>
                                    <td>
                                        <a href="{{url('kepegawaian/unit/show/'.$unit->id)}}">
                                            {{$unit->nama}}
                                        </a>
                                    </td>
                                    <td>
                                        {{$unit->unit_jabatan_pegawai->count()}}
                                    </td>
                                    <td>
                                        <form onsubmit="return confirm('Apakah Anda Yakin mengahapus unit {{$unit->nama}}?');" action="{{ route('unit.destroy', $unit->id) }}" method="POST">
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
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>
@foreach ($units as $unit)
<div class="modal fade" id="editUnit{{$unit->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('unit.update', $unit->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$unit->nama}}" placeholder="Nama Unit">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="" cols="30" rows="10">{{$unit->keterangan}}</textarea>
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