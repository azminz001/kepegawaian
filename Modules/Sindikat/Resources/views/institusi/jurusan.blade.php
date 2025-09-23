@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

  <style>
    .flatpickr-calendar {
        z-index: 99999999; /* Pastikan ini lebih tinggi daripada z-index modal */
    }
</style>

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
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item" aria-current="page">Institusi</li>
        <li class="breadcrumb-item active" aria-current="page">Jurusan</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-certificate icon-lg mx-2"></i> Data Jurusan Institusi</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createRiwayatDiklat">Tambah Jurusan Baru</a>
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
                                            <th class="">Nama</th>
                                            <th class="">Jenjang</th>
                                            <th class="">Keterangan</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($jurusans as $key => $jurusan)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                <span class="badge rounded-pill border border-success text-success">{{$jurusan->nama}}</span><br>
                                                <p class="mt-1 mb-1"><strong>{{$riwayat_diklat->nama_diklat}}</strong></p>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                <strong>{{$riwayat_diklat->institusi_penyelenggara}}</strong> <br>
                                                Tempat Diklat: <span class="badge rounded-pill border border-primary text-primary">{{$riwayat_diklat->tempat}}</span><br>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @if ($riwayat_diklat->tanggal_selesai != null)
                                                    {{date('d-M-Y', strtotime($riwayat_diklat->tanggal_mulai))}} s.d {{date('d-M-Y', strtotime($riwayat_diklat->tanggal_selesai))}}
                                                @else
                                                    {{date('d-M-Y', strtotime($riwayat_diklat->tanggal_mulai))}} 
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_diklat->durasi}} JP
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data anak {{$riwayat_diklat->nama_diklat}}?');" action="{{ route('riwayat_diklat.destroy', $riwayat_diklat->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $riwayat_diklat->id }}"  data-bs-toggle="modal" data-bs-target="#editRiwayatDiklat">
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
                                            <td colspan="6"><small>Tidak ada data Riwayat Diklat Pegawai</small></td>
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

<div class="modal fade" id="createRiwayatDiklat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Riwayat Diklat Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('riwayat_diklat.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Diklat*</label>
                                    <select name="jenis_diklat" class="form-control" required>
                                        <option disabled selected value>- Pilih Jenis Diklat -</option>
                                        <option value="Diklat">Diklat</option>
                                        <option value="Workshop">Workshop</option>
                                        <option value="Pelatihan">Pelatihan</option>
                                        <option value="Seminar">Seminar</option>
                                        <option value="Bimbingan Teknis">Bimbingan Teknis</option>
                                        <option value="Kursus">Kursus</option>
                                        <option value="Magang">Magang</option>
                                    </select>
                                    @error('jenis_diklat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Diklat*</label>
                                    <input type="text" class="form-control" name="nama_diklat" placeholder="Nama Diklat" required>
                                    @error('nama_diklat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Institusi Penyelenggara*</label>
                                    <input type="text" class="form-control"  name="institusi_penyelenggara" placeholder="Institusi Penyelenggara" required>
                                    @error('institusi_penyelenggara')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor Sertifikat</label>
                                    <input type="text" class="form-control" name="nomor_sertifikat" placeholder="Nomor Sertifikat">
                                    @error('nomor_sertifikat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Mulai*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_mulai" required data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_mulai')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Selesai</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_selesai" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_selesai')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tahun Diklat*</label>
                                    <input type="number" class="form-control" name="tahun_diklat" placeholder="Tahun Diklat">
                                    @error('tahun_diklat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Masa Berlaku</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="masa_berlaku" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('masa_berlaku')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tempat Diklat*</label>
                                    <input type="text" class="form-control" name="tempat" placeholder="Brebes / Jakarta / Semarang">
                                    @error('tempat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Durasi (JP)</label>
                                    <input type="number" class="form-control" name="durasi" placeholder="Durasi (JP)">
                                    @error('durasi')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Dokumen Sertifikat*</label>
                                    <input type="file" class="form-control" name="dokumen_sertifikat" accept = "application/pdf">
                                    @error('sertifikat')
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

<div class="modal fade" id="editRiwayatDiklat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Detail Riwayat Diklat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRiwayatDiklatForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">

                            <div class="col-lg-6 col-sm-12">
                                <iframe id="dokumen_sertifikat_embed" type="application/pdf" width="100%" height="720px"></iframe>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jenis Diklat*</label>
                                            <select name="jenis_diklat" id="jenis_diklat" class="form-control" required>
                                                <option disabled selected value>- Pilih Jenis Diklat -</option>
                                                <option value="Diklat">Diklat</option>
                                                <option value="Workshop">Workshop</option>
                                                <option value="Pelatihan">Pelatihan</option>
                                                <option value="Seminar">Seminar</option>
                                                <option value="Bimbingan Teknis">Bimbingan Teknis</option>
                                                <option value="Kursus">Kursus</option>
                                                <option value="Magang">Magang</option>
                                            </select>
                                            @error('jenis_diklat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Diklat*</label>
                                            <input type="text" class="form-control" id="nama_diklat" name="nama_diklat" placeholder="Nama Diklat" required>
                                            @error('nama_diklat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Institusi Penyelenggara*</label>
                                            <input type="text" class="form-control" id="institusi_penyelenggara"  name="institusi_penyelenggara" placeholder="Institusi Penyelenggara" required>
                                            @error('institusi_penyelenggara')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nomor Sertifikat</label>
                                            <input type="text" class="form-control" id="nomor_sertifikat" name="nomor_sertifikat" placeholder="Nomor Sertifikat">
                                            @error('nomor_sertifikat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Mulai*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" data-input required>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tanggal_mulai')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Selesai</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" data-input>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tanggal_selesai')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tahun Diklat*</label>
                                            <input type="text" class="form-control" id="tahun_diklat" name="tahun_diklat" placeholder="Tahun Diklat" required>
                                            @error('tahun_diklat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Masa Berlaku</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="masa_berlaku" name="masa_berlaku" data-input>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('masa_berlaku')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
        
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tempat Diklat*</label>
                                            <input type="text" class="form-control" id="tempat" name="tempat" placeholder="Brebes / Jakarta / Semarang" required>
                                            @error('tempat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Durasi (JP)</label>
                                            <input type="number" class="form-control" id="durasi" name="durasi" placeholder="Durasi (JP)">
                                            @error('durasi')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Dokumen Sertifikat</label>
                                            <input type="file" class="form-control" name="dokumen_sertifikat" accept = "application/pdf">
                                            @error('sertifikat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-block me-2">Simpan</button>
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
        var baseUrl = '{{ url('/') }}';
        $('#editRiwayatDiklat').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var riwayatDiklatId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_diklat/edit/' + riwayatDiklatId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#jenis_diklat').val(data.jenis_diklat);
                    $('#nama_diklat').val(data.nama_diklat);
                    $('#institusi_penyelenggara').val(data.institusi_penyelenggara);
                    $('#nomor_sertifikat').val(data.nomor_sertifikat);
                    $('#tahun_diklat').val(data.tahun_diklat);
                    $('#tanggal_mulai').val(data.tanggal_mulai);
                    $('#tanggal_selesai').val(data.tanggal_selesai);
                    $('#masa_berlaku').val(data.masa_berlaku);
                    $('#tempat').val(data.tempat);
                    $('#durasi').val(data.durasi);

                    var formAction = "{{ route('riwayat_diklat.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRiwayatDiklatForm').attr('action', formAction);

                    var embedSrc = baseUrl + '/storage/dokumen_pegawai/' + data.pegawai_id + '/' + data.dokumen_sertifikat;
                    $('#dokumen_sertifikat_embed').attr('src', embedSrc);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>