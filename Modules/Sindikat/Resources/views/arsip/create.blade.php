@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">SINDIKAT</li>
        <li class="breadcrumb-item active" aria-current="page">Arsip</li>
        <li class="breadcrumb-item active" aria-current="page">Baru</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Buat Arsip Materi / Dokumentasi</h3>
<div class="card p-3">
    <div class="row">
        <div class="col-md-2 pe-0">
            <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link bg-primary text-light"><strong>Pilih Jenis Arsip:</strong></a>
                <a class="nav-link active p-3" id="v-home-tab" data-bs-toggle="pill" href="#v-home" role="tab" aria-controls="v-home" aria-selected="true">Arsip Materi Baru</a>
                <a class="nav-link p-3" id="v-profile-tab" data-bs-toggle="pill" href="#v-profile" role="tab" aria-controls="v-profile" aria-selected="false">Arsip Dokumentasi Baru</a>
            </div>
        </div>
        <div class="col-md-10 ps-0">
            <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                <div class="tab-pane fade show active" id="v-home" role="tabpanel" aria-labelledby="v-home-tab">
                    <h5 class="mb-3">Arsip Materi</h5>
                    <form action="{{route('sindikat.arsip.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-9">
                                <div class="mb-3">
                                    <input type="hidden" name="jenis" value="1">
                                    <label for="" class="form-label">Pilih Kategori Arsip</label>
                                    <select name="kategori_id" class="form-control" id="">
                                        <option disabled selected value=""> - Pilih Kategori - </option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('nama')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Judul Arsip Materi</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="judul" placeholder="Judul Arsip Materi">
                                    @error('judul')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Isi Materi</label>
                                    <textarea name="content" class="form-control" id="tinymceExample" rows="10"></textarea>
                                    @error('content')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success me-2">Simpan</button>
                            </div>
                            <div class="col-3 alert alert-success">
                                <h6 class="mb-1">Upload File Arsip: <small>gambar/pdf</small></h6>
                                <div id="file-arsip-wrapper_materi">
                                    <div class="file-arsip">
                                        <label for="" class="mt-2">Deskripsi File</label>
                                        <input type="text" id="file_deskripsi_1" name="file_deskripsi[]" class="form-control mb-2" required>
                                        <label for="file_1">File:</label>
                                        <input type="file" id="file_1" name="file[]" class="form-control" required>
                                    </div>
                                </div>
                                <button type="button" onclick="addFileArsip(1)" class="btn btn-xs btn-success mt-1">Tambah File Arsip</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="v-profile" role="tabpanel" aria-labelledby="v-profile-tab">
                    <h5 class="mb-3">Arsip Dokumentasi</h5>
                    <form action="{{route('sindikat.arsip.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-9">
                                <div class="mb-3">
                                    <input type="hidden" name="jenis" value="2">
                                    <label for="" class="form-label">Pilih Kategori Arsip</label>
                                    <select name="kategori_id" class="form-control" id="">
                                        <option disabled selected value=""> - Pilih Kategori - </option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('nama')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Judul Arsip Dokumentasi</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="judul" placeholder="Judul Arsip Dokumentasi">
                                    @error('judul')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Isi Dokumentasi</label>
                                    <textarea name="content" class="form-control" id="tinymceExample" rows="10"></textarea>
                                    @error('content')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success me-2">Simpan</button>
                            </div>
                            <div class="col-3 alert alert-primary">
                                <h6 class="mb-1">Upload File Arsip: <small>gambar</small></h6>
                                <div id="file-arsip-wrapper_dokumentasi">
                                    <div class="file-arsip">
                                        <label for="" class="mt-2">Deskripsi File</label>
                                        <input type="text" id="file_deskripsi_1" name="file_deskripsi[]" class="form-control mb-2" required>
                                        <label for="file_1">File:</label>
                                        <input type="file" id="file_1" name="file[]" class="form-control" required>
                                    </div>
                                </div>
                                <button type="button" onclick="addFileArsip(2)" class="btn btn-xs btn-success mt-1">Tambah File Arsip</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  @endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/tinymce.js') }}"></script>
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
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