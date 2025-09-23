@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item active" aria-current="page">Permohonan Diklat Pegawai</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Permohonan Diklat Pegawai</h3>
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
                                <h6 class="card-title mb-0">Riwayat Permohonan Diklat Pegawai {{$pegawai->nama ?? ''}}</h6>            
                                </div>
                            </div>

                            @if (Auth::user()->level == '2' || Auth::user()->level == '0')
                            <div class="pull-right">
                                <button class="btn btn-xs btn-success"  data-bs-toggle="modal" data-bs-target="#createPermohonanDiklat">Buat Permohonan Diklat</button>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @if (Auth::user()->level == '0' || Auth::user()->level == '4')
                                            <th>Pemohon</th>
                                        @endif
                                        <th>Nama Diklat</th>
                                        <th>Penyelenggara</th>
                                        <th>Kategori Diklat</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($diklats as $key => $diklat)
                                        <tr>
                                            <td scope="row"  style="font-size: 0.85em;">{{ $key + $diklats->firstItem() }}</td>
                                            @if (Auth::user()->level == '0' || Auth::user()->level == '4')
                                                <td style="font-size: 0.85em;">
                                                    <strong>{{$diklat->pegawai->nama}}</strong> 
                                                    <p class="mt-1">Unit Kerja : {{$diklat->pegawai->unit_jabatan_aktif->nama_unit ?? 'Belum atur nama unit kepegawaian' }}</p>
                                                </td>
                                            @endif
                                            <td  style="font-size: 0.85em;;word-wrap: break-word;white-space: normal;">
                                                {{$diklat->nama_diklat}}<br />
                                                @php
                                                    if ($diklat->jenis == 0) {
                                                        $jenis_diklat = 'Struktural';
                                                    }else if ($diklat->jenis == 1) {
                                                        $jenis_diklat = 'Fungsional';
                                                    }else if ($diklat->jenis == 2) {
                                                        $jenis_diklat = 'Teknis';
                                                    }else if ($diklat->jenis == 3) {
                                                        $jenis_diklat = 'Umum';
                                                    }else{
                                                        $jenis_diklat = 'Undefined';
                                                    }
                                                @endphp
                                                <span class="badge bg-danger mt-1">Diklat {{$jenis_diklat}}</span>
                                            </td>
                                            <td  style="font-size: 0.85em;;word-wrap: break-word;white-space: normal;">
                                                {{$diklat->penyelenggara}}<br />
                                                Tempat: {{$diklat->tempat}}
                                            </td>
                                            <td  style="font-size: 0.85em;">
                                                @php
                                                    if ($diklat->tipe == 0) {
                                                        $tipe_diklat = 'Luring (Offline)';
                                                    }else if ($diklat->tipe == 1) {
                                                        $tipe_diklat = 'Daring (Online)';
                                                    }else if ($diklat->tipe == 2) {
                                                        $tipe_diklat = 'Hybrid (Offline dan Online)';
                                                    }else{
                                                        $tipe_diklat = 'Undefined';
                                                    }
                                                @endphp
                                                {{$tipe_diklat}} 
                                            </td>
                                            <td  style="font-size: 0.85em;">
                                                {{date_format(date_create($diklat->tanggal_mulai), 'd-M-Y')}} s.d {{date_format(date_create($diklat->tanggal_selesai), 'd-M-Y')}}
                                            </td>
                                            <td  style="font-size: 0.85em;">
                                                @if ($diklat->link!="")
                                                <a href="{{$diklat->link}}}" target="blank" class="btn btn-primary btn-xs">Buka</a>
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @php
                                                    $color = "";
                                                    $message = "";
                                                    if ($diklat->status == 0) {
                                                        $color = "primary";
                                                        $message = "Permohonan Diajukan";
                                                    }elseif ($diklat->status == 1) {
                                                        $color = "success";
                                                        $message = "Permohonan Dikonfirmasi";
                                                    }elseif ($diklat->status == 2) {
                                                        $color = "primary";
                                                        $message = "Permohonan Dikoordinasikan";
                                                    }elseif ($diklat->status == 3) {
                                                        $color = "primary";
                                                        $message = "Permohonan dalam Proses";
                                                    }elseif ($diklat->status == 4) {
                                                        $color = "success";
                                                        $message = "Permohonan Disetujui";
                                                    }elseif ($diklat->status == 5) {
                                                        $color = "danger";
                                                        $message = "Permohonan Ditolak";
                                                    }
                                                @endphp
                                                <span class="badge border border-dark text-dark">{{$message}}</span>
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus Permohonan {{$diklat->nama_diklat}}?');" action="{{ route('sindikat.permohonan_diklat.destroy', $diklat->id) }}" method="POST">
                                                    <a href="{{route('sindikat.permohonan_diklat.show', $diklat->id)}}"><span type="button" class="btn btn-info btn-xs btn-icon">
                                                    {{-- <span type="button" class="btn btn-info btn-xs btn-icon" data-id="{{ $diklat->id }}"  data-bs-toggle="modal" data-bs-target="#editPermohonanDiklat"> --}}
                                                        <i data-feather="eye"></i>
                                                    </span></a>
                                                    @if ($diklat->status != '4' && $diklat->status != '5')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Permohonan {{$diklat->nama_diklat}}">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <p class="text-danger">Tidak ada pengajuan permohonan diklat.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $diklats->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>
                            {{-- <small>Menampilkan {{$users->count()}} data dari total {{$user_count}} Pegawai.</small> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>

<div class="modal fade" id="createPermohonanDiklat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Permohonan Diklat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('sindikat.permohonan_diklat.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="col-sm-12 col-lg-12">
                        <div class="mb-3">
                            <label for="" class="form-label">Nama </label> 
                            <input type="text" class="form-control" autocomplete="off" name="nama_diklat" placeholder="Nama, Tema, atau Judul Diklat" required>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Penyelenggara</label> 
                                    <input type="text" class="form-control" autocomplete="off" name="penyelenggara" placeholder="Penyelenggara Diklat" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tempat</label>
                                    <input type="text" class="form-control" autocomplete="off" name="tempat" placeholder="Tempat Diklat" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Model </label>
                                    <select name="tipe" class="form-control" id="" required>
                                        <option value="">- Pilih Model Diklat -</option>
                                        <option value="0">Luring (Offline)</option>
                                        <option value="1">Daring (Online)</option>
                                        <option value="2">Hybrid (Online dan Offline)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Diklat</label>
                                    <select name="jenis" class="form-control" >
                                        <option value="">- Pilih Jenis Diklat -</option>
                                        <option value="0">Struktural</option>
                                        <option value="1">Fungsional</option>
                                        <option value="2">Teknis</option>
                                        <option value="3">Umum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Mulai</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_mulai" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Selesai</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_selesai" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Link</label> 
                                    <input type="text" class="form-control" autocomplete="off" name="link" placeholder="Berikan Link Apabila ada Informasi Detail Diklat">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Unggah Nota Dinas/Brosur/Flyer (Gambar/PDF)</label>
                                    <input type="file" class="form-control" name="upload" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-10">
                            <div class="alert alert-primary" role="alert">
                                <strong>Informasi</strong>
                                <p>Pilih nama sendiri apabila mengajukan diri sendiri, jika peserta diklat lebih dari satu pegawai maka cukup 1 pemohon yang mendaftarkan beberapa pegawai sebagai peserta diklat</p>
                            </div>
                            <label class="form-label">Pilih Pegawai Peserta Diklat</label>
                            <select class="js-example-basic-multiple form-select select2" name="pegawai_id[]" multiple="multiple" data-width="100%">
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->nama}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="" class="form-label">Catatan Tambahan</label>
                            <textarea name="catatan" cols="30" rows="5" class="form-control" placeholder="Berikan Catatan atau Informasi tambahan terkait Diklat"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success me-2 mt-2">Ajukan Permohonan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 
<div class="modal fade" id="editPermohonanDiklat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Detail Permohonan Diklat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRequestForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <iframe id="dokumen_embed" type="application/pdf" width="100%" height="720px" style="display: none;"></iframe>
                                <img id="dokumen_image" src="" alt="Dokumen Gambar" style="display: none; max-width: 100%; height: auto;">
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" id="pegawai_id">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama </label> 
                                        <input type="text" class="form-control" autocomplete="off" name="nama_diklat" id="nama_diklat" placeholder="Nama, Tema, atau Judul Diklat">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Penyelenggara</label> 
                                                <input type="text" class="form-control" id="penyelenggara" autocomplete="off" name="penyelenggara"  placeholder="Penyelenggara Diklat">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tempat</label>
                                                <input type="text" class="form-control" id="tempat" autocomplete="off" name="tempat" placeholder="Tempat Diklat">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Model </label>
                                                <select name="tipe" class="form-control" id="tipe">
                                                    <option value="0">Luring (Offline)</option>
                                                    <option value="1">Daring (Online)</option>
                                                    <option value="2">Hybrid (Offline dan Online)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Jenis Diklat</label>
                                                <select name="jenis" class="form-control" id="jenis">
                                                    <option value="0">Struktural</option>
                                                    <option value="1">Fungsional</option>
                                                    <option value="2">Teknis</option>
                                                    <option value="3">Umum</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tanggal Mulai</label>
                                                <div class="input-group flatpickr" id="flatpickr-date">
                                                    <input type="text" class="form-control" name="tanggal_mulai" id="tanggal_mulai" data-input>
                                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tanggal Selesai</label>
                                                <div class="input-group flatpickr" id="flatpickr-date">
                                                    <input type="text" class="form-control" name="tanggal_selesai" id="tanggal_selesai" data-input>
                                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Link</label> 
                                        <input type="text" class="form-control" id="link" autocomplete="off" name="link" placeholder="Berikan Link Apabila ada Informasi Detail Diklat">
                                    </div>
                                    @if (Auth::user()->level == '2')
                                    <div class="mb-3">
                                        <label for="" class="form-label">Perbarui Unggahan Informasi Diklat (Gambar/PDF)</label>
                                        <input type="file" class="form-control" name="upload">
                                    </div>
                                    @elseif (Auth::user()->level == '4' || Auth::user()->level == '0')
                                    <div class="mb-3">
                                        <label for="" class="form-label">Status Permohonan: <span class="badge">{{$message ?? '-'}}</span></label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="0">Diajukan</option>
                                            <option value="1">Dikonfirmasi</option>
                                            <option value="2">Dikoordinasikan</option>
                                            <option value="3">Dalam Proses</option>
                                            <option value="4">Disetujui</option>
                                            <option value="5">Ditolak</option>
                                        </select>
                                    </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="" class="form-label">Catatan Tambahan</label>
                                        <textarea name="catatan" id="catatan" cols="30" rows="5" class="form-control" placeholder="Berikan Catatan atau Informasi tambahan terkait Diklat"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div> --}}

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>

  
  
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    $('#createPermohonanDiklat').on('shown.bs.modal', function () {
        $('.select2').select2({
            dropdownParent: $('#createPermohonanDiklat') // Ensure the dropdown is appended to the modal
        });
    });
});
</script>

<script>
    /*$(document).ready(function() {
        var baseUrl = '{{ url('/') }}';
        $('#editPermohonanDiklat').on('show.bs.modal', function(event) {
            // console.log('Oalah');
            var button = $(event.relatedTarget);
            var permohonanId = button.data('id');

            var url = baseUrl + '/sindikat/permohonan_diklat/edit/' + permohonanId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // console.log(data);
                    $('#nama_diklat').val(data.nama_diklat);
                    $('#penyelenggara').val(data.penyelenggara);
                    $('#tempat').val(data.tempat);
                    $('#tipe').val(data.tipe);
                    $('#jenis').val(data.jenis);
                    $('#paid_status').val(data.paid_status);
                    $('#tanggal_mulai').val(data.tanggal_mulai);
                    $('#tanggal_selesai').val(data.tanggal_selesai);
                    $('#link').val(data.link);
                    $('#status').val(data.status);
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#catatan').val(data.catatan);

                    
                    var formAction = "{{ route('sindikat.permohonan_diklat.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRequestForm').attr('action', formAction);
                    
                    
                    var filePath = baseUrl + '/storage/dokumen_pegawai/' + data.pegawai_id + '/' + data.upload;
                    var fileExtension = data.upload.split('.').pop().toLowerCase();
                    
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
    }); */
</script>