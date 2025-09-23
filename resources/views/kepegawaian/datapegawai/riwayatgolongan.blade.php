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
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Golongan Pegawai</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-account-box-outline icon-lg mx-2"></i>Data Riwayat Golongan Pegawai</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createJabatanPegawai">Tambah Riwayat Golongan</a>
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
                                            <th class="text-center">Tanggal</th>
                                            <th class="">Golongan</th>
                                            <th class="text-center">Golongan Terakhir</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($riwayat_golongans as $key => $riwayat_golongan)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                <table>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">No. Surat BKN</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge rounded-pill border border-primary text-primary">{{$riwayat_golongan->no_surat_bkn}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">Nomor SK</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge rounded-pill border border-danger text-danger">{{$riwayat_golongan->sk_nomor}}</span></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                <table>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">TMT Golongan</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge rounded-pill border border-success text-success">{{date('d-M-Y', strtotime($riwayat_golongan->tmt))}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">Tanggal SK</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge rounded-pill border border-secondary text-secondary">{{date('d-M-Y', strtotime($riwayat_golongan->sk_tanggal))}}</span></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @if ($pegawai->status_kepegawaian == 'PNS')
                                                {{$riwayat_golongan->golongan->golongan_pns}} {{$riwayat_golongan->golongan->nama_pangkat_pns}}
                                                @elseif ($pegawai->status_kepegawaian == 'PPPK')
                                                {{$riwayat_golongan->golongan->golongan_pppk}}
                                                @endif
                                            </td>
                                            <?php
                                                $warna = "";
                                                $icon  = "";
                                                if($riwayat_golongan->is_golongan_terakhir == 1){
                                                    $warna = "success";
                                                    $icon = "check";
                                                }else{
                                                    $warna = "danger";
                                                    $icon = "x";
                                                }
                                                
                                            ?>
                                            <td class="text-center" style="font-size: 0.85em;"><span data-feather="{{$icon}}-circle" class="text-{{$warna}}"></span></td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus unit ini?');" action="{{ route('riwayat_golongan.destroy', $riwayat_golongan->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $riwayat_golongan->id }}"  data-bs-toggle="modal" data-bs-target="#editRiwayatGolongan">
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
                                            <td colspan="6"><small>Tidak ada data Riwayat Golongan Pegawai</small></td>
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
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Riwayat Golongan Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('riwayat_golongan.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. Surat BKN*</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" name="no_surat_bkn" placeholder="Nomor Surat BKN" required>
                                    @error('no_surat_bkn')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor SK*</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" name="sk_nomor" placeholder="Nomor SK" required>
                                    @error('sk_nomor')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TMT Pangkat/Golongan*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tmt" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tmt')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal SK*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="sk_tanggal" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('sk_tanggal')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Golongan/Pangkat*</label>
                                    <select name="golongan_id" id="" class="form-control select2" style="width: 100%" required>
                                        <option value="">- Pilih Golongan / Pangkat -</option>
                                        @foreach ($golongans as $golongan)
                                            <option value="{{$golongan->id}}">{{($pegawai->status_kepegawaian == 'PNS') ? $golongan->golongan_pns : $golongan->golongan_pppk}}</option>
                                        @endforeach
                                    </select>
                                    @error('golongan_id')
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
                                        <input type="checkbox" name="is_golongan_terakhir" value="1" class="form-check-input" id="checkInline1">
                                        <label class="form-check-label" for="checkInline1">
                                        Konfirmasi Golongan / Pangkat terakhir Anda saat ini
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

<div class="modal fade" id="editRiwayatGolongan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Detail Riwayat Golongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRiwayatGolonganForm" method="post" enctype="multipart/form-data">
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
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. Surat BKN*</label>
                                            <input type="text" class="form-control" name="no_surat_bkn" id="no_surat_bkn" placeholder="Nomor Surat BKN" required>
                                            @error('no_surat_bkn')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nomor SK*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="sk_nomor" name="sk_nomor"  required>
                                            </div> 
                                            @error('sk_nomor')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">TMT Pangkat/Golongan*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tmt" name="tmt" data-input required>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tmt')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal SK*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="sk_tanggal" name="sk_tanggal" data-input required>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('sk_tanggal')
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
                                                <input type="checkbox" name="is_golongan_terakhir" id="is_golongan_terakhir" class="form-check-input" value="1">
                                                <label class="form-check-label" for="is_golongan_terakhir">
                                                    Konfirmasi Golongan / Pangkat terakhir Anda saat ini
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
        $('#editRiwayatGolongan').on('show.bs.modal', function(event) {
            $('.select2').select2({
                dropdownParent: $('#editRiwayatGolongan') // Ensure the dropdown is appended to the modal
            });
            var button = $(event.relatedTarget);
            var riwayatGolonganId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_golongan/edit/' + riwayatGolonganId;

            console.log(url);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#tmt').val(data.tmt);
                    $('#no_surat_bkn').val(data.no_surat_bkn);
                    $('#sk_nomor').val(data.sk_nomor);
                    $('#sk_tanggal').val(data.sk_tanggal);

                    $('#is_golongan_terakhir').prop('checked', data.is_golongan_terakhir == 1);

                    var formAction = "{{ route('riwayat_golongan.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRiwayatGolonganForm').attr('action', formAction);
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