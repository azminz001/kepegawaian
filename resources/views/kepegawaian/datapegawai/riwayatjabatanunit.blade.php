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
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Jabatan Unit</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-hospital-building icon-lg mx-2"></i> Data Riwayat Jabatan Unit</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createJabatanPegawai">Tambah Riwayat Jabatan Unit</a>
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
                                            <th class="">TMT Jabatan Unit</th>
                                            <th class="">Unit</th>
                                            <th class="text-center">Jabatan</th>
                                            <th class="">Jabatan saat ini</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($riwayat_jabatan_units as $key => $riwayat_jabatan)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                {{date('d-M-Y', strtotime($riwayat_jabatan->tmt_jabatan_unit))}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_jabatan->unit->nama}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                <span class="badge bg-success">{{$riwayat_jabatan->jabatan_unit->jenis_jabatan->nama}}</span> :
                                                {{$riwayat_jabatan->jabatan_unit->nama}}
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
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus unit ini?');" action="{{ route('riwayat_jabatan_unit.destroy', $riwayat_jabatan->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $riwayat_jabatan->id }}"  data-bs-toggle="modal" data-bs-target="#editRiwayatJabatanUnit">
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
                                            <td colspan="6"><small>Tidak ada data Riwayat Jabatan Unit Pegawai</small></td>
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
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Riwayat Jabatan Unit Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('riwayat_jabatan_unit.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TMT Jabatan Unit</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tmt_jabatan_unit" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tmt_jabatan_unit')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Unit Kepegawaian</label>
                                    <select name="unit_id" id="" class="form-control select2" required>
                                        <option value="">- Pilih Unit Kepegawaian -</option>
                                        @foreach ($units as $unit)
                                            <option value="{{$unit->id}}">{{$unit->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jabatan Unit</label>
                                    <select name="jabatan_unit_id" class="form-control select2" data-width="100%" required>
                                        <option value="">- Pilih Jabatan Unit -</option>
                                        @foreach ($jabatan_units as $jabatan)
                                            <option value="{{$jabatan->id}}">{{$jabatan->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_unit_id')
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


<div class="modal fade" id="editRiwayatJabatanUnit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Ubah Riwayat Jabatan Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRiwayatJabatanForm" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" id="pegawai_id">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="tmt_jabatan_unit" class="form-label">TMT Jabatan Unit</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" id="tmt_jabatan_unit" name="tmt_jabatan_unit" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tmt_jabatan_unit')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="unit_id" class="form-label">Unit Kepegawaian</label>
                                    <select name="unit_id" id="unit_id" class="form-control select2" data-width="100%">
                                    </select>
                                    @error('unit_id')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="jabatan_unit_id" class="form-label">Jabatan Unit</label>
                                    <select name="jabatan_unit_id" id="jabatan_unit_id" class="form-control select2" data-width="100%">

                                    </select>
                                    @error('jabatan_unit_id')
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
        $('#editRiwayatJabatanUnit').on('show.bs.modal', function(event) {
            $('.select2').select2({
                dropdownParent: $('#editRiwayatJabatanUnit') // Ensure the dropdown is appended to the modal
            });
            var button = $(event.relatedTarget);
            var riwayatJabatanId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_jabatan_unit/edit/' + riwayatJabatanId;


            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#tmt_jabatan_unit').val(data.tmt_jabatan_unit);
                    // Populate Unit Select2
                    $.ajax({
                        url: baseUrl + '/kepegawaian/units',
                        method: 'GET',
                        success: function(units) {
                            $('#unit_id').empty().select2({
                                data: units.map(function(unit) {
                                    return {
                                        id: unit.id,
                                        text: unit.nama
                                    };
                                })
                            }).val(data.unit_id).trigger('change');
                        }
                    });
                    // Populate Jabatan Unit Select2
                    $.ajax({
                        url: baseUrl + '/kepegawaian/jabatan_units',
                        method: 'GET',
                        success: function(jabatan_units) {
                            $('#jabatan_unit_id').empty().select2({
                                data: jabatan_units.map(function(jabatan) {
                                    return {
                                        id: jabatan.id,
                                        text: jabatan.nama
                                    };
                                })
                            }).val(data.jabatan_unit_id).trigger('change');
                        }
                    });

                    $('#is_jabatan_terakhir').prop('checked', data.is_jabatan_terakhir == 1);

                    var formAction = "{{ route('riwayat_jabatan_unit.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRiwayatJabatanForm').attr('action', formAction);
                },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>