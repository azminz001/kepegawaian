@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Rapat</li>
        <li class="breadcrumb-item active" aria-current="page">Master Ruangan</li>
    </ol>
</nav>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">TAMBAH RUANG RAPAT BARU</h6>
                <form action="{{ route('rapat.master_ruangan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Nama Ruangan *</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" placeholder="masukan nama ruangan" style="text-transform: uppercase;" required>
                        @error('nama')
                        <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Kapasitas *</label>
                        <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="kapasitas" placeholder="masukan kapasitas ruangan" required>
                        @error('kapasitas')
                        <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-success me-2">SIMPAN</button>
                    </div>
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
                                    <h6 class="card-title mb-0">DAFTAR RUANG RAPAT RSUD BREBES</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('rapat.master_ruangan.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="cari nama ruangan ...">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">NAMA RUANGAN</th>
                                        <th class="text-center">KAPASITAS</th>
                                        <th class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ruang_rapat as $key => $ruangan)
                                    <tr>
                                        <td>{{$ruangan->nama}}</td>
                                        <td>{{$ruangan->kapasitas}}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex gap-1">
                                                <button type="button" class="btn btn-xs btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#editRuangan{{ $ruangan->id }}"><i data-feather="edit"></i></button>

                                                <form onsubmit="return confirm('Apakah Anda yakin menghapus {{ $ruangan->nama }} ini?');"
                                                    action="{{ route('rapat.master_ruangan.destroy', $ruangan->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon" data-bs-toggle="tooltip" title="Hapus">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Belum ada data ruang rapat.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                                <ul class="pagination justify-content-center">
                                    {{ $ruang_rapat->onEachSide(0)->links('pagination::bootstrap-4') }}
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

@foreach ($ruang_rapat as $ruangan)
<div class="modal fade" id="editRuangan{{ $ruangan->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UBAH DATA RUANG RAPAT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('rapat.master_ruangan.update', $ruangan->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Ruang Rapat</label>
                                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$ruangan->nama}}" style="text-transform: uppercase;" required>
                                @error('nama')
                                <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Kapasitas</label>
                                <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="kapasitas" value="{{$ruangan->kapasitas}}" required>
                                @error('kapasitas')
                                <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-success">SIMPAN</button>
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