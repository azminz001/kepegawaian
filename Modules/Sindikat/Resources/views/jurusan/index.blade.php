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
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item" aria-current="page">Institusi</li>
        <li class="breadcrumb-item active" aria-current="page">Jurusan/Program Studi/Program Keahlian</li>
    </ol>
</nav>
<h4 class="page-title mb-4">{{$institusi->nama}} <small class="text-muted">{{$institusi->provinsi}}</small></h4> 
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-3 grid-margin">
        @include('sindikat::institusi.sidebar')
    </div>
    <div class="col-sm-12 col-md-9 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0"><i class="mdi mdi-account-box-outline icon-lg mx-2"></i> Data Jurusan/Program Studi/Kompetensi Keahlian/Konsentrasi Keahlian</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createJurusan">Tambah Jurusan Baru</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">No</th>
                                            <th class="text-center">Nama Jurusan</th>
                                            <th class="text-center">Jenjang</th>
                                            <th class="text-center">Peserta Didik</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($majors as $key => $major)
                                        <tr>
                                            <td class="text-center" scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                {{$major->nama}}
                                            </td>
                                            <td class="text-center" style="font-size: 0.85em;">
                                                {{$major->jenjang->nama}}
                                            </td>
                                            <td class="text-center">
                                                {{$major->peserta_didik->count()}}
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data jurusan {{$major->nama}}?');" action="{{ route('sindikat.jurusan.destroy', $major->id) }}" method="POST">
                                                    <button type="button" class="btn btn-primary btn-xs btn-icon">
                                                        <i data-feather="users"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $major->id }}"  data-bs-toggle="modal" data-bs-target="#editMajor">
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

<div class="modal fade" id="createJurusan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Jurusan Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('sindikat.jurusan.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="institusi_id" value="{{$institusi->id}}">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Jurusan</label>
                                <input type="text" class="form-control" name="nama" id="" placeholder="Nama Jurusan">
                                @error('nama')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Jenjang Pendidikan</label>
                                <select name="jenjang_id" class="form-control">
                                    <option selected empty value>- Pilih Jenjang Pendidikan -</option>
                                    @foreach ($jenjangs as $jenjang)
                                        <option value="{{$jenjang->id}}">{{$jenjang->nama}}</option>
                                    @endforeach
                                </select>
                                @error('jabatan')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editMajor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editMajorForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Jurusan</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Jurusan">
                                @error('nama')
                                    <code>{{$message}}</code>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Jenjang Pendidikan</label> <br>
                                <select name="jenjang_id" id="jenjang_id" class="form-control select2" style="width:100%">
                                </select>
                                @error('jenjang_id')
                                    <code>{{$message}}</code>
                                @enderror
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
        $('#editMajor').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var jurusanId = button.data('id');
            var url = baseUrl + '/sindikat/jurusan/edit/' + jurusanId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // console.log(data);
                    $('#nama').val(data.nama);
                    // $('#nama_instansi').val(data.nama_instansi);
                    // $('#jabatan').val(data.jabatan);
                    // $('#tahun_mulai').val(data.tahun_mulai);
                    // $('#tahun_selesai').val(data.tahun_selesai);
                    // $('#kota').val(data.kota);
                    // $('#keterangan').val(data.keterangan);
                    $.ajax({
                        url: baseUrl + '/sindikat/jenjangs',
                        method: 'GET',
                        success: function(jenjangs) {
                            $('#jenjang_id').empty().select2({
                                data: jenjangs.map(function(jenjang) {
                                    return {
                                        id: jenjang.id,
                                        text: jenjang.nama
                                    };
                                })
                            }).val(data.jenjang_id).trigger('change');
                        }
                    });
                    var formAction = "{{ route('sindikat.jurusan.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editMajorForm').attr('action', formAction);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>