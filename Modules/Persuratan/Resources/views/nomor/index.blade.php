@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <p>
        Penomoran surat pada aplikasi ini dimulai pada tanggal 1 Oktober 2024,
        jadi pengambilan nomor mundur sebelum tanggal tersebut menggunakan penomoran manual pada admin persuratan.
        Sistem ini tidak mendukung pengambilan nomor <b>MELEBIHI</b> tanggal sekarang !!
    </p>
</div>
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Persuratan</li>
        <li class="breadcrumb-item active" aria-current="page">Nomor Surat</li>
    </ol>
</nav>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card rounded">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ms-2">
                    <h6 class="card-title mb-0">DAFTAR NOMOR SURAT YANG PERNAH SAYA BUAT</h6>            
                    </div>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-3 middle-wrapper">
                        <button type="submit" class="btn btn-xs btn-success" data-bs-toggle="modal" data-bs-target="#ambilNomor"><i data-feather="plus"></i> AMBIL NOMOR</button>
                    </div>
                    <div class="col-sm-12 col-md-9 middle-wrapper">
                        <form action="{{ route('persuratan.nomor.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="cari nomor surat">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 middle-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">NOMOR SURAT</th>
                                <th class="text-center">TANGGAL SURAT</th>
                                <th class="text-center">NAMA SURAT</th>
                            @if (Auth::user()->level != 2)
                                <th class="text-center">PENGOLAH</th>
                            @endif
                                <th class="text-center">STATUS</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($nomor as $key => $no)
                                <tr>
                                    <td style="font-size: 0.85em;">{{$key + $nomor->firstItem()}}</td>
                                    <td style="font-size: 0.85em;">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#uploadSurat{{ $no->id }}">
                                            {{$no->kode_klas."/".$no->nomor.$no->kelompok."/".$no->bulan."/".$no->tahun}}
                                        </a>
                                    </td>
                                    <td style="font-size: 0.85em;">{{date('d-m-Y', strtotime($no->tanggal_surat))}}</td>
                                    <td style="font-size: 0.85em;">{{$no->nama_surat}}</td>
                                @if (Auth::user()->level != 2)
                                    <td style="font-size: 0.85em;">{{$no->user_name}}</td>
                                @endif
                                    <td style="font-size: 0.85em;">
                                    @if ($no->status == "DIGUNAKAN")
                                        <span class="badge rounded-pill border border-success text-success">{{$no->status}}</span>
                                    @else
                                        {{$no->status}}
                                    @endif
                                    </td>
                                    <td style="font-size: 0.85em;" class="text-center">
                                        @if ($no->status == "DIGUNAKAN")
                                            <button onclick="showPDFInModal(`{{ asset('storage/persuratan/penomoran/' . $no->file) }}`)" type="button" class="btn btn-default btn-xs btn-icon" data-bs-toggle="modal" data-bs-target="#pdfModal">
                                                <i data-feather="eye"></i>
                                            </button>
                                            <a href="{{ asset('storage/persuratan/penomoran/' . $no->file) }}" target="blank" class="btn btn-primary btn-xs btn-icon">
                                                <i data-feather="download"></i>
                                            </a>
                                        @else
                                            <button type="button" class="btn btn-primary btn-xs btn-icon" data-bs-toggle="modal" data-bs-target="#editNomor{{$no->id}}">
                                                <i data-feather="edit"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    <div class="pull-right mt-4">
                      <ul class="pagination justify-content-center">
                        {{ $nomor->onEachSide(0)->links('pagination::bootstrap-4') }}
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
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">FILE SURAT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body" id="pdf-container">
                <!-- Canvas for PDF pages will be added dynamically here -->
            </div>
        </div>
    </div>
</div>
@foreach ($nomor as $no)
<div class="modal fade" id="uploadSurat{{$no->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">FILE SURAT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('persuratan.nomor.upload', $no->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Upload</label>
                                <small class="text-danger">PDF max 2MB</small>
                                <input type="file" class="form-control" name="file" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($nomor as $no)
<div class="modal fade" id="editNomor{{$no->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('persuratan.nomor.update', $no->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">KLASIFIKASI SURAT</label>
                                <select name="klasifikasi" class="form-control select2" data-width="100%" required>
                                    <option value="{{$no->id_klas}}">{{$no->kode_klas." ".$no->nama_klas}}</option>
                                @foreach ($klasifikasi as $klas)
                                    <option value="{{$klas->id}}">{{$klas->kode." ".$klas->nama}}</option>
                                @endforeach
                                </select>
                                @error('klasifikasi')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">NAMA SURAT</label>
                                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama_surat" value="{{$no->nama_surat}}" placeholder="masukkan nama surat">
                                @error('nama_surat')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">STATUS</label>
                                <select name="status" class="form-control">
                                    <option value="{{$no->status}}">{{$no->status}}</option>
                                    <option value="TIDAK DIGUNAKAN">TIDAK DIGUNAKAN</option>
                                    <option value="DIAMBIL">DIAMBIL</option>
                                </select>
                                @error('status')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="ambilNomor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ambil Nomor Surat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('persuratan.nomor.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">KLASIFIKASI SURAT</label>
                                <select name="klasifikasi" class="form-control select2" data-width="100%" required>
                                    <option value="" disabled selected>- Pilih Klasifikasi -</option>
                                @foreach ($klasifikasi as $klas)
                                    <option value="{{$klas->id}}">{{$klas->kode." ".$klas->nama}}</option>
                                @endforeach
                                </select>
                                @error('klasifikasi')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">NAMA SURAT</label>
                                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama_surat" value="" placeholder="masukkan nama surat" required>
                                @error('nama_surat')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">TANGGAL SURAT</label>
                                <input type="date" class="form-control" name="tanggal_surat" required>
                                @error('tanggal_surat')
                                    <code>{{$message}}</code>
                                @enderror
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
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/pdf/pdf.js') }}"></script>

<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('assets/js/pdf/pdf.worker.js') }}";

function showPDFInModal(pdfUrl) {
    const url = pdfUrl;

    // Clear previous content
    const container = document.getElementById('pdf-container');
    container.innerHTML = '';

    // Load the PDF
    pdfjsLib.getDocument(url).promise.then(function(pdf) {
        const numPages = pdf.numPages;

        // Get the container width
        const containerWidth = document.querySelector('#pdfModal .modal-body').clientWidth;

        // Loop through all pages
        for (let pageNum = 1; pageNum <= numPages; pageNum++) {
            pdf.getPage(pageNum).then(function(page) {
                const viewport = page.getViewport({ scale: 1 });
                
                // Calculate scale to fit the width
                const scale = containerWidth / viewport.width;
                const scaledViewport = page.getViewport({ scale: scale });

                // Create a canvas for each page
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = scaledViewport.width;
                canvas.height = scaledViewport.height;
                container.appendChild(canvas);

                const renderContext = {
                    canvasContext: context,
                    viewport: scaledViewport
                };
                page.render(renderContext);
            });
        }
    }, function(reason) {
        console.error('Error loading PDF: ' + reason);
    });

    // Show the PDF modal
    var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'), {});
    pdfModal.show();

    document.addEventListener('hidden.bs.modal', function (event) {
        // Menghapus modal-backdrop secara manual jika masih ada
        document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
            backdrop.remove();
        });
    });
}

$(document).ready(function() {
    // Inisialisasi select2 pada modal ambilNomor
    $('#ambilNomor').on('shown.bs.modal', function () {
        $('.select2').select2({
            dropdownParent: $('#ambilNomor') // Ensure the dropdown is appended to the modal
        });
    });

    // Inisialisasi select2 pada modal editNomor
    $('body').on('shown.bs.modal', function (e) {
        var modal = $(e.target);
        modal.find('.select2').select2({
            dropdownParent: modal // Ensure the dropdown is appended to the modal
        });
    });
});
</script>