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
    </ol>
</nav>
<h3 class="page-title mb-2">Forum Diskusi Pengisian Data SIM-RSUD Brebes</h3>
<div class="card p-3">
    <div class="row">
        <div class="col-md-2 pe-0">
            <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link p-1" ><button class="btn btn-success btn-block w-100" data-bs-toggle="modal" data-bs-target="#createKeluhan"><i class="link-icon mx-2" data-feather="message-square"></i> Buat Diskusi Baru</button></a>
                <a class="nav-link active p-3" id="v-home-tab" data-bs-toggle="pill" href="#v-home" role="tab" aria-controls="v-home" aria-selected="true"><i class="link-icon mx-2" data-feather="message-circle"></i> Diskusi Terbaru</a>
                <a class="nav-link p-3" id="v-profile-tab" data-bs-toggle="pill" href="#v-profile" role="tab" aria-controls="v-profile" aria-selected="false"><i class="link-icon mx-2" data-feather="at-sign"></i>Diskusi Saya</a>
            </div>
        </div>
        <div class="col-md-10 ps-0">
            <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                <div class="tab-pane fade show active" id="v-home" role="tabpanel" aria-labelledby="v-home-tab">
                    <h5 class="mb-3">Diskusi Terbaru</h5>
                    <form action="{{ route('data_pegawai.keluhan.cari') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <i class="btn-icon-prepend" data-feather="search"></i>
                            </div>
                            <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Tema/Judul Diskusi">
                            <button type="submit" class="btn btn-secondary btn-icon-text" style="margin-right: 14px">Cari</button>
                            <div class="dropdown">
                                <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="show">
                                    <button type="submit" class="btn btn-primary btn-icon-text"><i class="btn-icon-prepend" data-feather="filter"></i>Tampilkan</button>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" data-popper-placement="top-end" style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate3d(0px, -22.8571px, 0px);">
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i class="btn-icon-prepend icon-sm mx-2" data-feather="check-circle"></i><span class=""> Selesai</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="#"><i class="btn-icon-prepend icon-sm mx-2" data-feather="message-circle"></i><span class=""> Ada Balasan</span></a>
                                </div>

                            </div>
                        </div>
                    </form>
                    <div class="alert alert-success" role="alert">
                        <strong>Informasi</strong>
                        <p>Saat ini SIM-RSUD dalam mode development / pengembangan, oleh karena itu dalam proses pengisian data Anda terkadang akan mengalami tampilan Error kode program, tidak perlu kawatir Anda bisa tangkap layar atau screenshoot dan laporkan kepada IT Team RSUD Brebes melalui Forum Diskusi ini.</p>
                    </div>
                    @forelse ($complaints as $complaint)
                    <div class="card mb-2" style="background-color: #dedede">
                        <div class="card-body">
                            <p align="right"><small>{{date_format(date_create($complaint->modified), 'd M Y')}}</small></p>
                            <h6><a href="{{route('data_pegawai.keluhan.diskusi', $complaint->id)}}"><strong>{{$complaint->judul}}</strong></a> <span class="badge {{$complaint->status == 1 ? 'bg-success': ''}} mx-2">{{$complaint->status == 1 ? 'Selesai' : ''}}</span></h6>
                            <p><small>oleh: {{$complaint->pengguna->name}}</small></p>
                            <p class="mt-2 mb-1">{!! Str::words($complaint->catatan, '25') !!}</p>
                            <form onsubmit="return confirm('Apakah Anda Yakin akan menghapus keluhan ini?');" action="{{ route('data_pegawai.keluhan.destroy', $complaint->id) }}" method="POST">
                            <p align="right">
                                    <span class="btn btn-xs btn-success">Pembahasan : {{$complaint->balasan->count()}} Diskusi</span>
                                    @csrf
                                    @method('DELETE')
                                    @if (Auth::user()->level == 0 || Auth::user()->level == 1)
                                    <button class="btn btn-xs btn-danger btn-icon">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                    @endif
                                </p>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="card  alert alert-danger">
                        <div class="card-body">
                            <p>Tidak ada data Keluhan terbaru</p>
                        </div>
                    </div>
                        
                    @endforelse

                    <div class="pull-right mt-4">
                        <ul class="pagination justify-content-center">
                            {{ $complaints->onEachSide(0)->links('pagination::bootstrap-4') }}
                        </ul>
                    </div>
                    <small>Menampilkan {{$complaints->count()}} data dari total {{$complaint_count}} Diskusi.</small>
                </div>
                <div class="tab-pane fade" id="v-profile" role="tabpanel" aria-labelledby="v-profile-tab">
                    <h5 class="mb-3">Arsip Dokumentasi</h5>

                    @forelse ($user_complaints as $user_complaint)
                    <div class="card mb-2" style="background-color: #dedede">
                        <div class="card-body">
                            <p align="right"><small>{{date_format(date_create($user_complaint->modified), 'd M Y')}}</small></p>
                            <h6><a href="{{route('data_pegawai.keluhan.diskusi', $user_complaint->id)}}"><strong>{{$user_complaint->judul}}</strong></a> <span class="badge {{$user_complaint->status == 1 ? 'bg-success': ''}} mx-2">{{$complaint->status == 1 ? 'Selesai' : ''}}</span></h6>
                            <p><small>oleh: {{$user_complaint->pengguna->name}}</small></p>
                            <p class="mt-2 mb-1">{!! Str::words($user_complaint->catatan, '25') !!}</p>
                            <form onsubmit="return confirm('Apakah Anda Yakin keluhan ini?');" action="{{ route('data_pegawai.keluhan.destroy', $user_complaint->id) }}" method="POST">
                            <p align="right">
                                    <button class="btn btn-xs btn-success">Pembahasan : {{$user_complaint->balasan->count()}} Diskusi</button>
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger btn-icon">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </p>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="card  alert alert-danger">
                        <div class="card-body">
                            <p>Anda tidak memiliki data keluhan atau diskusi baru </p>
                        </div>
                    </div>
                        
                    @endforelse

                    <div class="pull-right mt-4">
                        <ul class="pagination justify-content-center">
                            {{ $user_complaints->onEachSide(0)->links('pagination::bootstrap-4') }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="createKeluhan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Buat Diskusi Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('data_pegawai.keluhan.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <div class="mb-3">
                            <label for="" class="form-label">Judul*</label>
                            <input type="text" class="form-control" name="judul" placeholder="Judul Diskusi" required>
                            @error('judul')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Catatan*</label>
                            <textarea name="catatan" class="form-control" id="tinymceExample" rows="10"></textarea>
                            @error('catatan')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="foto" class="form-label">Pilih Gambar</label>
                                <input type="file" name="gambar" class="form-control" id="myDropify">
                            </div>
                        </div>
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
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
  @endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/tinymce.js') }}"></script>
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
  <script>
        let fileArsipCount = 1;

        function addFileArsip(jenis) {
            fileArsipCount++;
            let wrapper;

            if (jenis == 1) {
                wrapper = document.getElementById('file-arsip-wrapper_materi');
            } else if (jenis == 2) {
                wrapper = document.getElementById('file-arsip-wrapper_dokumentasi');
            }

            if (wrapper) {
                const newFileArsip = document.createElement('div');
                newFileArsip.className = 'file-arsip';
                newFileArsip.setAttribute('id', `file-arsip-${fileArsipCount}`);
                newFileArsip.innerHTML = `
                    <label for="file_deskripsi_${fileArsipCount}" class="mt-4">Deskripsi File:</label>
                    <input type="text" id="file_deskripsi_${fileArsipCount}" name="file_deskripsi[]" class="form-control mb-2" required>
                    <label for="file_${fileArsipCount}">File:</label>
                    <input type="file" id="file_${fileArsipCount}" name="file[]" class="form-control mb-2" required>
                    <button type="button" class="btn btn-xs btn-danger mt-1" onclick="removeFileArsip(${fileArsipCount})">Hapus</button>
                `;
                wrapper.appendChild(newFileArsip);
            }
        }
        function removeFileArsip(id) {
            const element = document.getElementById(`file-arsip-${id}`);
            if (element) {
                element.remove();
            }
        }
  </script>

@endpush