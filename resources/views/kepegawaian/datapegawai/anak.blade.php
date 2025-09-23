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
        <li class="breadcrumb-item active" aria-current="page">Data Anak Pegawai</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-human-child icon-lg mx-2"></i> Data Anak Pegawai</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createAnak">Tambah Anak Pegawai</a>
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
                                            <th class="">Jenis Kelamin</th>
                                            <th class="text-center">Nomor</th>
                                            <th class="">Tanggal Lahir</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($anaks as $key => $anak)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                {{$anak->nama}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{($anak->jenis_kelamin == 0 ? "Laki-Laki": "Perempuan")}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                <table>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">NIK</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge rounded-pill border border-primary text-primary">{{$anak->nik}}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size: 0.85em;">No. BPJS</td>
                                                        <td style="font-size: 0.85em;">:</td>
                                                        <td style="font-size: 0.85em;"><span class="badge rounded-pill border border-success text-success">{{$anak->no_bpjs}}</span></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{date('d-M-Y', strtotime($anak->tanggal_lahir))}}
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data anak {{$anak->nama}}?');" action="{{ route('anak.destroy', $anak->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $anak->id }}"  data-bs-toggle="modal" data-bs-target="#editAnak">
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
                                            <td colspan="6"><small>Tidak ada data Anak Pegawai</small></td>
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

<div class="modal fade" id="createAnak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Anak Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('anak.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Kelamin*</label>
                                    <select name="jenis_kelamin" class="form-control" required>
                                        <option value="">- Pilih Jenis Kelamin -</option>
                                        <option value="0">Laki-Laki</option>
                                        <option value="1">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Lengkap*</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
                                    @error('nama')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIK*</label>
                                    <input type="text" class="form-control"  name="nik" placeholder="Nomor Induk Kependudukan" required>
                                    @error('nik')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. BPJS*</label>
                                    <input type="text" class="form-control" name="no_bpjs" placeholder="Nomor BPJS" required>
                                    @error('no_bpjs')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_lahir" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_lahir')
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

<div class="modal fade" id="editAnak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Detail Anak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editAnakForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Kelamin*</label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="0">Laki-Laki</option>
                                        <option value="1">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Lengkap*</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
                                    @error('nama')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIK*</label>
                                    <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Kependudukan" required>
                                    @error('nik')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. BPJS*</label>
                                    <input type="text" class="form-control" id="no_bpjs" name="no_bpjs" placeholder="Nomor BPJS" required>
                                    @error('no_bpjs')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_lahir')
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
        $('#editAnak').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var anakId = button.data('id');
            var url = baseUrl + '/kepegawaian/anak/edit/' + anakId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#jenis_kelamin').val(data.jenis_kelamin);
                    $('#nik').val(data.nik);
                    $('#no_bpjs').val(data.no_bpjs);
                    $('#nama').val(data.nama);
                    $('#tanggal_lahir').val(data.tanggal_lahir);

                    var formAction = "{{ route('anak.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editAnakForm').attr('action', formAction);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>