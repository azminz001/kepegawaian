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
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Jabatan Pegawai</li>
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
                                    <h6 class="card-title mb-0"><i class="btn-icon-prepend mx-2" data-feather="briefcase"></i>Data Riwayat Jabatan Pegawai</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createJabatanPegawai">Tambah Jabatan Pegawai</a>
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
                                            <th class="">Nomor SK</th>
                                            <th class="">Tanggal</th>
                                            <th class="">Jabatan</th>
                                            <th class="text-center">Jabatan Terakhir</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayat_jabatans as $key => $riwayat_jabatan)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_jabatan->no_sk}}
                                            </td>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">Tanggal SK</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge border border-primary text-primary">{{date('d-M-Y', strtotime($riwayat_jabatan->tanggal_sk))}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">TMT Jabatan</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge border border-primary text-primary">{{date('d-M-Y', strtotime($riwayat_jabatan->tmt_jabatan))}}</span></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                <span class="badge bg-success mb-1">{{$riwayat_jabatan->kelompok_jabatan->nama}}</span><br />
                                                {{$riwayat_jabatan->jabatan->nama}}
                                            </td>
                                            <?php
                                                $warna = "";
                                                $icon  = "";
                                                if($riwayat_jabatan->is_jabatan_terakhir == 1){
                                                    $warna = "success";
                                                    $icon = "check";
                                                }else{
                                                    $warna = "danger";
                                                    $icon = "x";
                                                }
                                                
                                            ?>
                                            <td class="text-center" style="font-size: 0.85em;"><span data-feather="{{$icon}}-circle" class="text-{{$warna}}"></span></td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus unit ini?');" action="{{ route('riwayat_jabatan.destroy', $riwayat_jabatan->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{$riwayat_jabatan->id}}" data-bs-toggle="modal" data-bs-target="#editRiwayatJabatan">
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
                                            <td colspan="6"><small>Tidak ada data Riwayat Jabatan Pegawai</small></td>
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

<div class="modal fade" id="createJabatanPegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Riwayat Jabatan Pegawai Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('riwayat_jabatan.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. SK*</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" name="no_sk" placeholder="Nomor Surat Keputusan" required>
                                    @error('no_sk')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal SK*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_sk" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div> 
                                    @error('tanggal_sk')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TMT Jabatan*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tmt_jabatan" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tmt_jabatan')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Gaji</label>
                                    <input class="form-control mb-4 mb-md-0" name="gaji" data-inputmask="'alias': 'currency', 'prefix':'Rp. '" inputmode="decimal" style="text-align: right;">
                                    @error('gaji')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kelompok Jabatan*</label>
                                    <select name="kel_jabatan_id" id="" class="form-control" required>
                                        <option value="">- Pilih Kelompok Jabatan -</option>
                                        @foreach ($kel_jabatans as $kel_jabatan)
                                            <option value="{{$kel_jabatan->id}}">{{$kel_jabatan->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('kel_jabatan_id')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jabatan*</label>
                                    <select name="jabatan_id" class="form-control select2" data-width="100%" required>
                                        <option value="">- Pilih Jabatan -</option>
                                        @foreach ($jabatans as $jabatan)
                                            <option value="{{$jabatan->id}}">{{$jabatan->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_id')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Eselon</label><code><small>Khusus Jabatan Struktural</small></code>
                                    <select name="eselon_id" class="form-control" data-width="100%" >
                                        <option value="">- Pilih Eselon -</option>
                                        @foreach ($eselons as $eselon)
                                            <option value="{{$eselon->id}}">{{$eselon->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('eselon_id')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Dokumen SK*</label>
                                    <input type="file" class="form-control" name="dokumen_sk" accept = "application/pdf" required>
                                    @error('dokumen_sk')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="alert alert-info" role="alert">
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="is_jabatan_terakhir" value="1" class="form-check-input" id="checkInline1">
                                        <label class="form-check-label" for="checkInline1">
                                        Konfirmasi Jabatan terakhir Anda saat ini
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

<div class="modal fade" id="editRiwayatJabatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Detail Riwayat Jabatan Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRiwayatJabatanForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">

                            <div class="col-lg-6 col-sm-12">
                                <iframe id="dokumen_sk_embed" type="application/pdf" width="100%" height="720px"></iframe>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" id="pegawai_id">
                                    <div class="alert alert-secondari" role="alert">
                                        <label for=""><strong>Status Jabatan: </strong> </label> &nbsp;<label for="" id="nama_jabatan"></label>
                                        <p><span class="badge bg-success" id="status_kesehatan"></span> <span class="badge bg-primary" id="status_medis"></span> <span class="badge bg-danger" id="status_perawatan"></span></p>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. SK*</label>
                                            <input type="text" class="form-control" name="no_sk" id="no_sk" placeholder="Nomor Surat Keputusan" required>
                                            @error('no_sk')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal SK*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tanggal_sk" name="tanggal_sk" data-input required>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div> 
                                            @error('tanggal_sk')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">TMT Jabatan*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tmt_jabatan" name="tmt_jabatan" data-input required>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tmt_jabatan')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Gaji</label>
                                            <input class="form-control mb-4 mb-md-0" id="gaji" name="gaji" data-inputmask="'alias': 'currency', 'prefix':'Rp. '" inputmode="decimal" style="text-align: right;">
                                            @error('gaji')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kelompok Jabatan*</label>
                                            <select name="kel_jabatan_id" id="kel_jabatan_id" class="form-control select2" data-width="100%" required>
                                            </select>
                                            @error('kel_jabatan_id')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jabatan*</label>
                                            <select name="jabatan_id" id="jabatan_id" class="form-control select2" data-width="100%" required>
                                            </select>
                                            @error('jabatan_id')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Eselon</label>
                                            <select name="eselon_id" id="eselon_id" class="form-control select2" data-width="100%" >
                                            </select>
                                            @error('eselon_id')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Ubah Dokumen SK</label>
                                            <input type="file" class="form-control" name="dokumen_sk" accept = "application/pdf">
                                            @error('dokumen_sk')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="alert alert-info" role="alert">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="is_jabatan_terakhir" id="is_jabatan_terakhir" class="form-check-input" value="1">
                                                <label class="form-check-label" for="is_jabatan_terakhir">
                                                    Konfirmasi Jabatan terakhir Anda saat ini
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
        $('#editRiwayatJabatan').on('show.bs.modal', function(event) {
            $('.select2').select2({
                dropdownParent: $('#editRiwayatJabatan') // Ensure the dropdown is appended to the modal
            });
            var button = $(event.relatedTarget);
            var riwayatJabatanId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_jabatan/edit/' + riwayatJabatanId;
            
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data.no_sk);
                    $('#tmt_jabatan').val(data.tmt_jabatan);
                    $('#no_sk').val(data.no_sk);
                    $('#tanggal_sk').val(data.tanggal_sk);
                    $('#gaji').val(data.gaji);

                    // Populate Kelompok Jabatan Select2
                    $.ajax({
                        url: baseUrl + '/kepegawaian/kelompok_jabatans',
                        method: 'GET',
                        success: function(kelompok_jabatans) {
                            $('#kel_jabatan_id').empty().select2({
                                data: kelompok_jabatans.map(function(kel_jabatan) {
                                    return {
                                        id: kel_jabatan.id,
                                        text: kel_jabatan.nama
                                    };
                                })
                            }).val(data.kel_jabatan_id).trigger('change');
                        }
                    });

                    // Populate Kelompok Jabatan Select2
                    $.ajax({
                        url: baseUrl + '/kepegawaian/detailJabatan/' + data.jabatan_id, 
                        method: 'GET',
                        success: function(detailJabatan){
                            // console.log(detailJabatan);
                            $('#nama_jabatan').text(detailJabatan.nama);
                            $('#status_kesehatan').text(detailJabatan.status_kesehatan);
                            $('#status_medis').text(detailJabatan.status_medis);
                            $('#status_perawatan').text(detailJabatan.status_perawatan);

                        }
                    });
                    $.ajax({
                        url: baseUrl + '/kepegawaian/jabatans',
                        method: 'GET',
                        success: function(jabatans) {
                            $('#jabatan_id').empty().select2({
                                data: jabatans.map(function(jabatan) {
                                    return {
                                        id: jabatan.id,
                                        text: jabatan.nama
                                    };
                                })
                            }).val(data.jabatan_id).trigger('change');
                        }
                    });
                    // $('#kel_jabatan_id').val(data.kel_jabatan_id);
                    // $('#jabatan_id').val(data.jabatan_id);
                    $('#pegawai_id').val(data.pegawai_id);
                    // Populate Kelompok Jabatan Select2
                    $.ajax({
                        url: baseUrl + '/kepegawaian/eselons',
                        method: 'GET',
                        success: function(eselons) {
                            $('#eselon_id').empty().select2({
                                data: eselons.map(function(eselon) {
                                    return {
                                        id: eselon.id,
                                        text: eselon.nama
                                    };
                                })
                            }).val(data.eselon_id).trigger('change');
                        }
                    });
                    $('#eselon_id').val(data.eselon_id);
                    $('#is_jabatan_terakhir').prop('checked', data.is_jabatan_terakhir == 1);

                    var formAction = "{{ route('riwayat_jabatan.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRiwayatJabatanForm').attr('action', formAction);

                    var embedSrc = baseUrl + '/storage/dokumen_pegawai/' + data.pegawai_id + '/' + data.dokumen_sk;
                    $('#dokumen_sk_embed').attr('src', embedSrc);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>