@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

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
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Gaji Berkala</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-cash-multiple icon-lg mx-2"></i> Data Riwayat Gaji Berkala</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createGajiBerkala">Tambah Gaji Berkala Baru</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="">No</th>
                                            <th class="">Nomor Surat</th>
                                            <th class="">Tanggal Surat</th>
                                            <th class="text-center">Gaji Pokok Lama</th>
                                            <th class="text-center">Gaji Pokok Baru</th>
                                            <th class="text-center">Tanggal Mulai Berlaku</th>
                                            <th class="">Gaji Berkala Terakhir</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($riwayat_gajis as $key => $riwayat_gaji)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_gaji->no_surat}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{date('d-M-Y', strtotime($riwayat_gaji->tanggal_surat))}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{"Rp " . number_format($riwayat_gaji->gaji_pokok_lama, 2, ",", ".")}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{"Rp " . number_format($riwayat_gaji->gaji_pokok_baru, 2, ",", ".")}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{date('d-M-Y', strtotime($riwayat_gaji->tanggal_mulai_berlaku))}}
                                            </td>
                                            <?php
                                                $warna = "";
                                                $icon  = "";
                                                if($riwayat_gaji->is_gaji_terakhir == 1){
                                                    $warna = "success";
                                                    $icon = "check";
                                                }else{
                                                    $warna = "danger";
                                                    $icon = "x";
                                                }
                                                
                                            ?>
                                            <td class="text-center" style="font-size: 0.85em;"><span data-feather="{{$icon}}-circle" class="text-{{$warna}}"></span></td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus gaji berkala ini?');" action="{{ route('riwayat_gaji_berkala.destroy', $riwayat_gaji->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $riwayat_gaji->id }}"  data-bs-toggle="modal" data-bs-target="#editRiwayatGajiBerkala">
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
                                        <tr>
                                            <td colspan="8"><small>Tidak ada data Riwayat Gaji Berkala Pegawai</small></td>
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

<div class="modal fade" id="createGajiBerkala" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Riwayat Gaji Berkala Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('riwayat_gaji_berkala.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor Surat</label>
                                    <input type="text" class="form-control" name="no_surat" data-input>
                                    @error('no_sk')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Surat</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_surat" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_surat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Gaji Pokok Lama</label>
                                    <input type="number" class="form-control" name="gaji_pokok_lama" data-input>
                                    @error('gaji_pokok_lama')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Gaji Pokok Baru</label>
                                    <input type="number" class="form-control" name="gaji_pokok_baru" data-input>
                                    @error('gaji_pokok_baru')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Mulai Berlaku</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_mulai_berlaku" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_mulai_berlaku')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Dokumen Gaji Berkala</label>
                                    <input type="file" class="form-control" name="dokumen_gaji" accept = "application/pdf">
                                    @error('dokumen_gaji')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="alert alert-info" role="alert">
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="is_gaji_terakhir" value="1" class="form-check-input" id="checkInline1">
                                        <label class="form-check-label" for="checkInline1">
                                        Konfirmasi gaji berkala terakhir Anda saat ini
                                        </label>
                                    </div>
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

<div class="modal fade" id="editRiwayatGajiBerkala" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Detail Riwayat Gaji Berkala Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRiwayatGajiBerkalaForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <iframe id="dokumen_gaji_embed" type="application/pdf" width="100%" height="720px"></iframe>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" id="pegawai_id">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nomor Surat</label>
                                            <input type="text" class="form-control" id="no_surat" name="no_surat" data-input>
                                            @error('no_sk')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Surat</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tanggal_surat" name="tanggal_surat" data-input>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tanggal_surat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Gaji Pokok Lama</label>
                                            <input type="number" class="form-control" id="gaji_pokok_lama" name="gaji_pokok_lama" data-input>
                                            @error('gaji_pokok_lama')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Gaji Pokok Baru</label>
                                            <input type="number" class="form-control" id="gaji_pokok_baru" name="gaji_pokok_baru" data-input>
                                            @error('gaji_pokok_baru')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Mulai Berlaku</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tanggal_mulai_berlaku" name="tanggal_mulai_berlaku" data-input>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tanggal_mulai_berlaku')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Dokumen Gaji Berkala</label>
                                            <input type="file" class="form-control" name="dokumen_gaji" accept = "application/pdf">
                                            @error('dokumen_gaji')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="alert alert-info" role="alert">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="is_gaji_terakhir" id="is_gaji_terakhir" class="form-check-input" value="1">
                                                <label class="form-check-label" for="is_gaji_terakhir">
                                                    Konfirmasi gaji berkala terakhir Anda saat ini
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success me-2">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>


@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
    $('#createJabatanPegawai').on('shown.bs.modal', function () {
        $('.select2').select2({
            dropdownParent: $('#createJabatanPegawai') // Ensure the dropdown is appended to the modal
        });
    });
});
</script>
<script>
    $(document).ready(function() {
        var baseUrl = '{{ url('/') }}';
        $('#editRiwayatGajiBerkala').on('show.bs.modal', function(event) {
            $('.select2').select2({
                dropdownParent: $('#editRiwayatGajiBerkala') // Ensure the dropdown is appended to the modal
            });
            var button = $(event.relatedTarget);
            var riwayatGajiId = button.data('id');

            var url = baseUrl + '/kepegawaian/riwayat_gaji_berkala/edit/' + riwayatGajiId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#no_surat').val(data.no_surat);
                    $('#tanggal_surat').val(data.tanggal_surat);
                    $('#tanggal_mulai_berlaku').val(data.tanggal_mulai_berlaku);
                    $('#gaji_pokok_lama').val(data.gaji_pokok_lama);
                    $('#gaji_pokok_baru').val(data.gaji_pokok_baru);
                    

                    $('#is_gaji_terakhir').prop('checked', data.is_gaji_terakhir == 1);

                    var formAction = "{{ route('riwayat_gaji_berkala.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRiwayatGajiBerkalaForm').attr('action', formAction);

                    var embedSrc = baseUrl + '/storage/dokumen_pegawai/' + data.pegawai_id + '/' + data.dokumen_gaji;
                    $('#dokumen_gaji_embed').attr('src', embedSrc);
                    
                },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>