@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item active" aria-current="page">Keluhan</li>
        <li class="breadcrumb-item active" aria-current="page">Diskusi</li>
    </ol>
</nav>
<h3 class="page-title mb-2">{{$complaint->judul}} <span class="badge {{$complaint->status == 1 ? 'bg-success': ''}} mx-2">{{$complaint->status == 1 ? 'Selesai' : ''}}</span></h3> 
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 middle-wrapper">
        <div class="row">
            <div class="col-md-10 col-sm-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0">Pembahasan</h6>            
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0">
                                {{-- <button class="btn btn-primary btn-sm btn-icon-text" data-bs-toggle="modal" data-bs-target="#updateComplaint"><i class="btn-icon-prepend" data-feather="edit"></i>Update Keluhan</button> --}}
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <p class="m-2 text-muted" align="right">Terakhir Update: {{date_format(date_create($complaint->modified), 'd M Y')}}</p>
                            <small>Oleh: {{$complaint->pengguna->name}}</small>
                            <div style="line-height: 1.8">
                                {!! $complaint->catatan !!}
                            </div>
                            @if ($complaint->gambar != null)
                            <img src="{{ asset('storage/kepegawaian/keluhan/'.$complaint->gambar) }}" class="w-100px w-sm-150px me-3 mt-3" style="width: 400px" alt="...">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-10 col-sm-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0">Diskusikan Topik ini</h6>            
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <button class="btn btn-success btn-sm btn-icon-text" data-bs-toggle="modal" data-bs-target="#createReply"><i class="btn-icon-prepend" data-feather="message-circle"></i>Tanggapi</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse ($replies as $reply)
                            <div class="card mb-3" style="background-color: #dedede">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p><small>Dari: {{$reply->pengguna->name}}</small></p>
                                            <p class="mt-2 mb-1">{!! $reply->balasan !!}</p>
                                            @if (Auth::user()->id == $reply->user_id || (Auth::user()->level == 0 || Auth::user()->level == 1))
                                                <form onsubmit="return confirm('Apakah Anda Yakin Tanggapan ini?');" action="{{ route('data_pegawai.keluhanbalasan.destroy', $reply->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <p class="mt-2">
                                                        <button class="btn btn-xs btn-danger btn-icon">
                                                            <i data-feather="trash-2"></i>
                                                        </button>
                                                    </p>
                                                </form>
                                            @endif
                                        </div>
                                        <div class="col-md-4">
                                            <p align="right"><small>{{date_format(date_create($reply->updated_at), 'd M Y H:m:s')}}</small></p>

                                            @if ($reply->gambar != null)
                                            <img src="{{ asset('storage/kepegawaian/keluhan/'.$reply->gambar) }}" class="w-100px w-sm-150px me-3 mt-3" style="width: 100%" alt="...">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="card  alert alert-danger">
                                <div class="card-body">
                                    <p>Belum ada diskusi pada Topik ini</p>
                                </div>
                            </div>
                                
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>

<div class="modal fade" id="createReply" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tanggapi Topik Diskusi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('data_pegawai.keluhanbalas.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="mb-3">
                            <input type="hidden" name="keluhan_id" value="{{$complaint->id}}">
                            <label for="form-label">Tanggapan Anda</label>
                            <textarea name="balasan" class="form-control" id="tinymceExample" rows="10"></textarea>
                            @error('balasan')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Pilih Gambar</label>
                            <input type="file" name="gambar" class="form-control" id="myDropify">
                        </div>
                        <div class="modal-body p-3">
                            <button type="submit" class="btn btn-success me-2">Simpan</button>
                        </div>
                    </div>
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