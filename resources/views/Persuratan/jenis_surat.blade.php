@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Persuratan</li>
        <li class="breadcrumb-item active" aria-current="page">Jenis Surat</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Jenis Surat</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Jenis Surat Baru</h6>
                <form action="{{route('jenis_surat.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Jenis Surat</label>
                        <input type="text" class="form-control" autocomplete="off" name="nama" placeholder="Nama Jenis Surat">
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
                    <h6 class="card-title mb-0">Daftar Data Jenis Surat</h6>            
                    </div>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="dataTableExample">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $key => $category)
                                <tr>
                                    <td scope="row">{{$key+1}}</td>
                                    <td>
                                        {{$category->nama}}
                                    </td>
                                    <td>
                                        <form onsubmit="return confirm('Apakah Anda Yakin mengahapus Jenis Surat {{$category->nama}}?');" action="{{ route('jenis_surat.destroy', $category->id) }}" method="POST">
                                            <button type="button" class="btn btn-primary btn-xs btn-icon"  data-bs-toggle="modal" data-bs-target="#editJenisSurat{{$category->id}}">
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
@foreach ($categories as $category)
<div class="modal fade" id="editJenisSurat{{$category->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('jenis_surat.update', $category->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Jenis Surat</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$category->nama}}" placeholder="Nama Jenis Surat">
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