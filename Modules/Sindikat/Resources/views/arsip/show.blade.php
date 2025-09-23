@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">SINDIKAT</li>
        <li class="breadcrumb-item active" aria-current="page">Arsip</li>
        <li class="breadcrumb-item active" aria-current="page">{{($arsip->jenis == 1) ? "Materi":"Dokumentasi"}}</li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
</nav>
<h3 class="page-title mb-2">{{$arsip->judul}}</h3>
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
                                    <h6 class="card-title mb-0">Detail Arsip {{($arsip->jenis == 1) ? "Materi":"Dokumentasi"}}</h6>            
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <button class="btn btn-primary btn-sm btn-icon-text" data-bs-toggle="modal" data-bs-target="#updateArsip"><i class="btn-icon-prepend" data-feather="edit"></i>Update Detail Arsip</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-8 px-3">
                                <p class="m-2 text-muted" align="right">Terakhir Update: {{date_format(date_create($arsip->modified), 'd M Y')}}</p>
                                <div style="line-height: 1.8">
                                    {!! $arsip->content !!}
                                </div>
                            </div>
                            <div class="col-4 p-2" style="background-color: #e5e5e5">
                                <h5>File Media / Dokumen:</h5>
                                <ul class="list-unstyled">
                                @forelse ($arsip->arsip_file as $arsip_file)
                                    @php
                                        // Ambil ekstensi file
                                        $extension = strtolower(pathinfo($arsip_file->file, PATHINFO_EXTENSION));
                                    @endphp
                                    <li class="d-flex align-items-start p-3">
                                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                                            <!-- Jika file adalah gambar -->
                                            <img src="{{ asset('storage/sindikat/file_arsip/'.$arsip_file->file) }}" class="w-100px w-sm-150px me-3" style="width: 200px" alt="...">
                                            <div>
                                                <h6 class="mt-0 mb-1">{{$arsip_file->deskripsi}}</h6>
                                                <form onsubmit="return confirm('Apakah Anda Yakin menghapus media {{$arsip_file->deskripsi}}?');" action="{{ route('sindikat.arsipfile.destroy', $arsip_file->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($extension == 'pdf')
                                            <!-- Jika file adalah PDF -->
                                            <a href="{{ asset('storage/sindikat/file_arsip/'.$arsip_file->file) }}" target="_blank" style="margin-right: 20px">{{ $arsip_file->file }}</a><br>
                                            <form onsubmit="return confirm('Apakah Anda Yakin menghapus media {{$arsip_file->deskripsi}}?');" action="{{ route('sindikat.arsipfile.destroy', $arsip_file->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs btn-icon">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        @else
                                            <!-- Jika file bukan gambar atau PDF -->
                                            <p>File format tidak dikenali: {{ $arsip_file->file }}</p>
                                        @endif
                                    </li>
                                @empty
                                    <li>Tidak ada File Media atau Dokumen yang ditambahkan</li>
                                @endforelse
                                </ul>
                                <button class="btn btn-sm btn-success" style="margin-left: 17px" data-bs-toggle="modal" data-bs-target="#tambahMedia"><i class="mdi mdi-image"></i> Tambah Media Baru</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>
<div class="modal fade" id="tambahMedia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Media Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('sindikat.arsipfile.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Deskripsi </label>
                        <input type="hidden" name="arsip_id" value="{{$arsip->id}}">
                        <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi Media">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Media</label>
                        <input type="file" name="file" class="form-control" id="myDropify">
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="updateArsip" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Update Arsip</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('sindikat.arsip.update', $arsip->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body p-3">
                    <div class="mb-3">
                        <label for="" class="form-label">Judul Arsip </label>
                        <input type="text" class="form-control" id="exampleInputUsername1" value="{{$arsip->judul}}" autocomplete="off" name="judul" placeholder="Judul Arsip">
                        @error('judul')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Isi </label>
                        <textarea name="content" class="form-control" id="tinymceExample" rows="25">{{$arsip->content}}</textarea>
                        @error('content')
                            <code>{{$message}}</code>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  @endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/tinymce.js') }}"></script>
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>

@endpush