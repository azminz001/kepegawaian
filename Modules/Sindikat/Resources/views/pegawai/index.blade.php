@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item active" aria-current="page">Instruktur</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Instruktur Klinik</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->

    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex justify-content-between flex-column flex-md-row">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0">Data Instruktur Klinik <small>(Clinical Instructure)</small> RSUD Brebes</h6>            
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <button class="btn btn-success btn-sm btn-icon-text" data-bs-toggle="modal" data-bs-target="#createPegawai"><i class="btn-icon-prepend" data-feather="user-plus"></i>Atur Pegawai Baru</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTableExample">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th>Nama</th>
                                        <th class="text-center">Kontak Pribadi</th>
                                        <th class="text-center">Jabatan Unit</th>
                                        <th class="text-center">Jabatan Pegawai</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pegawais as $key => $pegawai)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1 }}</td>
                                            <td>
                                                @if ($pegawai->foto == null)
                                                    <img src="{{ asset('assets/images/user-icon.png') }}" class="rounded-circle" style="width: 55px;height:55px" alt="" srcset="">
                                                @else
                                                    <div class="me-3">
                                                        <img src="{{ asset('storage/foto_pegawai/'.$pegawai->nip_nipppk_nrpk_nrpblud.'/'.$pegawai->foto) }}" class="rounded-circle" style="width: 55px;height:55px;object-fit: cover" alt="...">
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                <a href="{{url('sindikat/instruktur/profil/'.$pegawai->id)}}">
                                                    {{($pegawai->gelar_depan!=null)? $pegawai->gelar_depan.". ":""}}{{$pegawai->nama}}{{($pegawai->gelar_belakang!=null)?", ".$pegawai->gelar_belakang:""}}
                                                </a><br>
                                                <small class="text-muted">
                                                    @if ($pegawai->status_kepegawaian == 'PNS')
                                                        NIP.
                                                    @elseif ($pegawai->status_kepegawaian == 'PPPK')
                                                        NIPPPK. 
                                                    @elseif ($pegawai->status_kepegawaian == 'KONTRAK')
                                                        NRPK.
                                                    @elseif($pegawai->status_kepegawaian == 'BLUD' || $pegawai->status_kepegawaian == 'MITRA')
                                                        NRPBLUD.
                                                    @else
                                                    NIP/ NIPPPK/ NRPK/ NRPBLUD.
                                                    @endif
                                                    {{$pegawai->nip_nipppk_nrpk_nrpblud}}
                                                </small>
                                            </td>
                                            <td class="" style="font-size: 0.85em;">
                                                Email: {{$pegawai->email}} <br>
                                                No. HP : {{$pegawai->no_hp}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                <strong>
                                                    @if($pegawai->unit_jabatan_aktif)
                                                        {{ $pegawai->unit_jabatan_aktif->nama_unit }}
                                                    @endif
                                                </strong><br>
                                                @if($pegawai->unit_jabatan_aktif)
                                                    {{ $pegawai->unit_jabatan_aktif->nama_jabatan_unit }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @if($pegawai->jabatan_aktif)
                                                    {{ $pegawai->jabatan_aktif->nama_jabatan }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="" style="font-size: 0.85em;">
                                                @foreach ($pegawai->instruktur_klinik as $instruktur_klinik)
                                                <p style="font-size: 0.85em;">{{$instruktur_klinik->jenis_ci}}</p>
                                                <span class="badge rounded-pill border border-success text-success">No. SK: {{$instruktur_klinik->no_sk}}</span>
                                                <p>
                                                    <form onsubmit="return confirm('Apakah Anda Yakin mengahapus instruktur klinik ini?');" action="{{ route('riwayat_pegawai_ci.destroy', $instruktur_klinik->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-xs btn-danger mt-2" type="submit">Batalkan Instruktur Klinik</button>
                                                    </form>
                                                </p>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>Belum ada Pegawai yang mengaktifkat status sebagai Instruktur Klinik</td>
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
    <!-- middle wrapper end -->
</div>


<div class="modal fade" id="createPegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Atur Instruktur Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route('sindikat.pegawai.store')}}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="" class="form-label">Jenis Instruktur Klinik</label>
                            <select name="jenis_ci" id="jenis_ci" class="form-control">
                                <option disabled selected value>- Pilih Jenis Instruktur Klinik -</option>
                                <option value="PENDIDIK KLINIK">PENDIDIK KLINIK</option>
                                <option value="PEMBIMBING KLINIK">PEMBIMBING KLINIK</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label class="form-label">Pilih Pegawai</label>
                            <select class="js-example-basic-multiple form-select select2" name="pegawai_id[]" multiple="multiple" data-width="100%">
                            @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->nama}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="">Nomor SK</label>
                            <input type="text" class="form-control mt-2" name="no_sk" placeholder="Nomor Surat Keputusan sebagai Instruktur Klinik" required>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="" class="form-label">Tanggal SK</label>
                            <div class="input-group flatpickr" id="flatpickr-date">
                                <input type="text" class="form-control" name="tanggal_sk" data-input>
                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                            </div> 
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>

@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
    $('#createPegawai').on('shown.bs.modal', function () {
        $('.select2').select2({
            dropdownParent: $('#createPegawai') // Ensure the dropdown is appended to the modal
        });
    });
});
</script>