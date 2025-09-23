@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
 
@endpush
<style>
    .select2-container--open {
        z-index: 9999999;
    }
    .modal-open .select2-container--open {
        z-index: 9999999;
    }
</style>

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item" aria-current="page">Pegawai</li>
        <li class="breadcrumb-item active" aria-current="page">Dokumen Permohonan Kontrak</li>
    </ol>
</nav>
<h4 class="page-title mb-4">{{($pegawai->gelar_depan!=null)? $pegawai->gelar_depan.". ":""}}{{$pegawai->nama}}{{($pegawai->gelar_belakang!=null)?", ".$pegawai->gelar_belakang:""}} <small class="text-muted">{{$pegawai->nip_nipppk_nrpk_nrpblud}}</small></h4> 
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-3 grid-margin">
        @include('kepegawaian.datapegawai.sidebar_pegawai')
    </div>
    <div class="col-sm-12 col-md-9 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0"><i class="mdi mdi-file-document icon-lg mx-2"></i> Data Dokumen Permohonan Kontrak Pegawai</h6>     
                                </div>
                            </div>
                            {{-- @if (Auth::user()->level == '2') --}}
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createDokumen">Unggah Dokumen Baru</a>
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <h4>COba PDF Viewer</h4>
                            <div id="pdf-viewer"></div> --}}
                            {{-- <iframe src="https://drive.google.com/viewerng/viewer?embedded=true&url=https://www.antennahouse.com/hubfs/xsl-fo-sample/pdf/basic-link-1.pdf" width="100%" height="600"></iframe> --}}
                            <a href="https://docs.google.com/document/d/1_TSUbKGIjPBI7MwwkGOyupL4zsmeJG40/edit?usp=sharing&ouid=106379572297746170166&rtpof=true&sd=true" target="blank">
                                Download Format Permohonan Kontrak Kerja
                            </a>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="" width="5%">No</th>
                                            <th class="">Nama Dokumen</th>
                                            <th class="">Tanggal Permohonan</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($dokumens as $key => $dokumen)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                               {{$dokumen->nama_berkas}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{date('d-M-Y', strtotime($dokumen->tanggal_permohonan))}}
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data anak {{$dokumen->nama_berkas}}?');" action="{{ route('kontrak_kerja.destroy', $dokumen->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $dokumen->id }}"  data-bs-toggle="modal" data-bs-target="#bukaDokumen">
                                                        <i data-feather="eye"></i>
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
                                        <tr>
                                            <td colspan="4"><small>Tidak ada data Dokumen Pegawai</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>
{{-- @if(Auth::user()->level == 2) --}}
<div class="modal fade" id="createDokumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Upload Dokumen Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('kontrak_kerja.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Dokumen*</label>
                                    <input type="text" class="form-control" name="nama_berkas" placeholder="contoh: Surat Permohonan Kontrak John Doe" required>
                                    @error('nama_berkas')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Surat Permohonan*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_permohonan" required data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Dokumen* <span class="text-danger">(PDF)</span></label>
                                    <input type="file" class="form-control" name="file" id="myDropify" accept = "application/pdf" required>
                                    @error('file')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- @endif --}}
<div class="modal fade" id="bukaDokumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dokumen: <span id="nama_berkas"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <iframe id="dokumen_embed" type="application/pdf" width="100%" height="720px" style="display: none;"></iframe>
                        <img id="dokumen_image" src="" alt="Dokumen Gambar" style="display: none; max-width: 100%; height: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>

@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
  {{-- <script src="{{ asset('assets/js/pdf/pdf.js') }}"></script> --}}
  
  {{-- <script>
    const url = 'http://192.168.57.79/storage/dokumen_pegawai/9c099117-0e10-4128-92d4-b66d7a773544/29e3cf1e-9bf8-11ef-ba85-2e8a730f5cc5.pdf';
    const pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('assets/js/pdf/pdf.worker.js') }}";

    pdfjsLib.getDocument(url).promise.then(pdf => {
        pdf.getPage(1).then(page => {
            const scale = 1.5;
            const viewport = page.getViewport({ scale: scale });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            document.getElementById('pdf-viewer').appendChild(canvas);

            const renderContext = {
                canvasContext: context,
                viewport: viewport
            };
            page.render(renderContext);
        });
    });
</script> --}}


@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var baseUrl = '{{ url('/') }}';
        $('#bukaDokumen').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var dokumenId = button.data('id');

            console.log(dokumenId);
            var url = baseUrl + '/kepegawaian/permohonan_kontrak/edit/' + dokumenId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#nama_berkas').val(data.nama_berkas);
                    document.getElementById('nama_berkas').innerHTML = data.nama_berkas;

                    var filePath = baseUrl + '/storage/dokumen_pegawai/' + data.pegawai_id + '/' + data.file;
                    var fileExtension = data.file.split('.').pop().toLowerCase();

                    if (fileExtension === 'pdf') {
                        $('#dokumen_embed').attr('src', filePath).show();
                        $('#dokumen_image').hide();
                    } else if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                        $('#dokumen_image').attr('src', filePath).show();
                        $('#dokumen_embed').hide();
                    } else {
                        alert('File type not supported.');
                    }
                },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>