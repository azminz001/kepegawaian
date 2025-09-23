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
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Pekerjaan Pegawai</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-account-box-outline icon-lg mx-2"></i> Data Riwayat Pekerjaan Pegawai</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createPekerjaan">Tambah Riwayat Pekerjaan Baru</a>
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
                                            <th class="">Nama Perusahaan/Institusi</th>
                                            <th class="">Jabatan</th>
                                            <th class="text-center">Tahun</th>
                                            <th class="">Keterangan</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($riwayat_pekerjaans as $key => $pekerjaan)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                <strong>{{$pekerjaan->nama_instansi}}</strong><br>
                                                Kota/Kab. {{$pekerjaan->kota}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$pekerjaan->jabatan}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @if ($pekerjaan->tahun_selesai != null)
                                                    {{$pekerjaan->tahun_mulai}} - {{$pekerjaan->tahun_selesai}}
                                                @else
                                                    {{$pekerjaan->tahun_mulai}}
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$pekerjaan->keterangan}}
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data anak {{$pekerjaan->nama}}?');" action="{{ route('riwayat_pekerjaan.destroy', $pekerjaan->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $pekerjaan->id }}"  data-bs-toggle="modal" data-bs-target="#editPekerjaan">
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
                                            <td colspan="6"><small>Tidak ada data Riwayat Pekerjaan Pegawai</small></td>
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

<div class="modal fade" id="createPekerjaan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Riwayat Pekerjaan Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('riwayat_pekerjaan.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Perusahaan / Institusi</label>
                                    <input type="text" class="form-control" name="nama_instansi" id="" placeholder="Nama Perusahaan / Institusi">
                                    @error('nama_instansi')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jabatan / Posisi</label>
                                    <input type="text" class="form-control" name="jabatan" placeholder="Jabatan / Posisi">
                                    @error('jabatan')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tahun Mulai</label>
                                    <input type="number" class="form-control"  name="tahun_mulai" placeholder="Tahun Mulai">
                                    @error('tahun_mulai')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tahun Selesai</label>
                                    <input type="number" class="form-control"  name="tahun_selesai" placeholder="Tahun Selesai">
                                    @error('tahun_selesai')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kota / Kabupaten</label>
                                    <input type="text" class="form-control" name="kota" placeholder="Kota / Kabupaten">
                                    @error('jabatan')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" id="" cols="30" rows="5" placeholder="Deskripsi Singkat Pekerjaan di Perusahaan / Institusi"></textarea>
                                    @error('keterangan')
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

<div class="modal fade" id="editPekerjaan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Ubah Riwayat Pekerjaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editPekerjaanForm" method="post">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="container"><div class="row">
                        <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Perusahaan / Institusi</label>
                                <input type="text" class="form-control" name="nama_instansi" id="nama_instansi" placeholder="Nama Perusahaan / Institusi">
                                @error('nama')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Jabatan / Posisi</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Jabatan / Posisi">
                                @error('jabatan')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Tahun Mulai</label>
                                <input type="number" class="form-control" id="tahun_mulai"  name="tahun_mulai" placeholder="Tahun Mulai">
                                @error('tahun_mulai')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Tahun Selesai</label>
                                <input type="number" class="form-control" id="tahun_selesai"  name="tahun_selesai" placeholder="Tahun Selesai">
                                @error('tahun_selesai')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Kota / Kabupaten</label>
                                <input type="text" class="form-control" id="kota" name="kota" placeholder="Kota / Kabupaten">
                                @error('jabatan')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="5" placeholder="Deskripsi Singkat Pekerjaan di Perusahaan / Institusi"></textarea>
                                @error('keterangan')
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
        $('#editPekerjaan').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var pekerjaanId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_pekerjaan/edit/' + pekerjaanId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#nama_instansi').val(data.nama_instansi);
                    $('#jabatan').val(data.jabatan);
                    $('#tahun_mulai').val(data.tahun_mulai);
                    $('#tahun_selesai').val(data.tahun_selesai);
                    $('#kota').val(data.kota);
                    $('#keterangan').val(data.keterangan);

                    var formAction = "{{ route('riwayat_pekerjaan.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editPekerjaanForm').attr('action', formAction);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>