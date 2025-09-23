@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">SINDIKAT</li>
        <li class="breadcrumb-item active" aria-current="page">Kategori</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Arsip Sindikat</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                <h6 class="card-title mb-0">Daftar Arsip Sindikat Kategori {{$category->nama}}</h6>            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <form action="{{ route('sindikat.arsip.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="btn-icon-prepend" data-feather="search"></i>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Arsip {{$nama}}">
                                <button type="submit" class="btn btn-secondary btn-icon-text" style="margin-right: 14px">Cari</button>
                            </div>
                        </form> --}}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="10%"></th>
                                        <th>Judul</th>
                                        <th>Slug (Link)</th>
                                        <th>Jenis Arsip</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($arsips as $key => $arsip)
                                        <tr>
                                            <td width="5%" scope="row">{{$key+1}}</td>
                                            <td>

                                                @if (!isset($arsip->get_thumbnail->file))
                                                    <img src="{{ asset('assets/images/user-icon.png') }}" class="mx-2" style="width: 75px;height:75px" alt="" srcset="">
                                                @else
                                                    <div class="me-3">
                                                        <img src="{{ asset('storage/sindikat/file_arsip/'.$arsip->get_thumbnail->file) }}" class="mx-2" style="width: 75px;height:75px;object-fit: cover" alt="...">
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="word-wrap: break-word;white-space: normal;">
                                                <a href="{{url('sindikat/arsip/'.$arsip->slug)}}">
                                                    {{$arsip->judul}}
                                                </a>
                                            </td>
                                            <td style="word-wrap: break-word;white-space: normal;">{{$arsip->slug}}</td>
                                            <td style="word-wrap: break-word;white-space: normal;">{{($arsip->jenis == 1) ? "Materi" : "Dokumentasi"}}</td>
                                            <td>
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus arsip {{$arsip->judul}}?');" action="{{ route('sindikat.arsip.destroy', $arsip->id) }}" method="POST">
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
                                {{ $arsips->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>
                            <small>Menampilkan {{$arsips->count()}} data dari total {{$arsip_count}} Arsip {{$category->nama}}.</small>
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
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>

@endpush