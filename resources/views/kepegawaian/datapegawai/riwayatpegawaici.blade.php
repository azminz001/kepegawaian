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
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Instruktur Klinik Unit</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-account-network icon-lg mx-2"></i> Data Riwayat Instruktur Klinik</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createPegawaiCI">Tambah Riwayat Instruktur Klinik</a>
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
                                            <th class="">Jenis Instruktur Klinik</th>
                                            <th class="">Surat Keputusan</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Aktif</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($pegawai_cis as $key => $ci)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                {{$ci->jenis_ci}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                <table>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">Nomor SK</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge rounded-pill border border-primary text-primary">{{$ci->no_sk}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">Tangagl SK</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge rounded-pill border border-success text-success">{{date('d-M-Y', strtotime($ci->tanggal_sk))}}</span></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$ci->keterangan}}
                                            </td>
                                            <?php
                                                $warna = "";
                                                $icon  = "";
                                                if($ci->status == 1){
                                                    $warna = "success";
                                                    $icon = "check";
                                                }else{
                                                    $warna = "danger";
                                                    $icon = "x";
                                                }
                                                
                                            ?>
                                            <td class="text-center" style="font-size: 0.85em;"><span data-feather="{{$icon}}-circle" class="text-{{$warna}}"></span></td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus instruktur klinik ini?');" action="{{ route('riwayat_pegawai_ci.destroy', $ci->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $ci->id }}"  data-bs-toggle="modal" data-bs-target="#editRiwayatPegawaiCI">
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
                                            <td colspan="6"><small>Tidak memiliki Riwayat Instruktur Klinik</small></td>
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

<div class="modal fade" id="createPegawaiCI" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Riwayat Instruktur Klinik</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('riwayat_pegawai_ci.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor SK</label>
                                    <input type="text" name="no_sk" class="form-control" placeholder="Nomor SK" id="">
                                    @error('no_sk')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal SK</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_sk" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_sk')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Instruktur Klinik</label>
                                    <select name="jenis_ci" class="form-control">
                                        <option disabled selected value>- Pilih Jenis Instruktur Klinik -</option>
                                        <option value="PENDIDIK KLINIK">PENDIDIK KLINIK</option>
                                        <option value="PEMBIMBING KLINIK">PEMBIMBING KLINIK</option>
                                    </select>
                                    @error('jenis_ci')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" placeholder="Informasi tambahan sebagai Instruktur Klinik" id="">
                                    @error('keterangan')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="alert alert-info" role="alert">
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="status" value="1" class="form-check-input" id="checkInline1">
                                        <label class="form-check-label" for="checkInline1">
                                        Konfirmasi Instruktur Klinik Anda saat ini
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

<div class="modal fade" id="editRiwayatPegawaiCI" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Ubah Riwayat Instruktur Klinik</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRiwayatPegawaiCIForm" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nomor SK</label>
                                    <input type="text" name="no_sk" class="form-control" placeholder="Nomor SK" id="no_sk">
                                    @error('no_sk')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal SK</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" id="tanggal_sk" name="tanggal_sk" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_sk')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Instruktur Klinik</label>
                                    <select name="jenis_ci" id="jenis_ci" class="form-control">
                                        <option disabled selected value>- Pilih Jenis Instruktur Klinik -</option>
                                        <option value="PENDIDIK KLINIK">PENDIDIK KLINIK</option>
                                        <option value="PEMBIMBING KLINIK">PEMBIMBING KLINIK</option>
                                    </select>
                                    @error('jenis_ci')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control" id="keterangan" placeholder="Informasi tambahan sebagai Instruktur Klinik" id="">
                                    @error('keterangan')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12">
                                <div class="alert alert-info" role="alert">
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="status" id="status" class="form-check-input" value="1">
                                        <label class="form-check-label" for="status">
                                            Konfirmasi Instruktur Klinik Anda saat ini
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
        $('#editRiwayatPegawaiCI').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var ciId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_pegawai_ci/edit/' + ciId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#no_sk').val(data.no_sk);
                    $('#tanggal_sk').val(data.tanggal_sk);
                    $('#jenis_ci').val(data.jenis_ci);
                    $('#keterangan').val(data.keterangan);

                    $('#status').prop('checked', data.status == 1);

                    var formAction = "{{ route('riwayat_pegawai_ci.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRiwayatPegawaiCIForm').attr('action', formAction);
                },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>