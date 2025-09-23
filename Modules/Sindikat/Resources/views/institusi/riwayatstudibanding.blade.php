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
        <li class="breadcrumb-item active" aria-current="page">Permohonan Studi Banding</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-account-box-outline icon-lg mx-2"></i> Data Riwayat Permohonan Studi Banding</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createRequest">Tambah Permohonan Baru</a>
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
                                            <th class="text-center">Surat</th>
                                            <th class="text-center">Periode Magang</th>
                                            <th class="text-center">Peserta Didik</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($magangs as $key => $magang)
                                        <tr>
                                            <td class="text-center" scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                Tanggal : {{date_format(date_create($magang->tanggal_surat), 'd-M-Y')}}
                                                <p class="mt-2">No. Surat: <span class="badge bg-danger">{{$magang->no_surat}}</span></p>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @php
                                                    $tanggal_mulai = new DateTime($magang->tanggal_mulai);
                                                    $tanggal_selesai = new DateTime($magang->tanggal_selesai);

                                                    // Menghitung selisih antara tanggal mulai dan tanggal selesai
                                                    $selisih = $tanggal_mulai->diff($tanggal_selesai);

                                                    // Menghitung durasi dalam bulan
                                                    $durasi_bulan = ($selisih->y * 12) + $selisih->m;
                                                @endphp 
                                                {{date_format(date_create($magang->tanggal_mulai), 'd-M-Y')}} s.d {{date_format(date_create($magang->tanggal_selesai), 'd-M-Y')}}
                                                <p class="mt-2"><span class="badge bg-success">Durasi: {{$durasi_bulan}} Bulan</span></p>
                                            </td>
                                            <td class="text-center" style="font-size: 0.85em;">
                                                @if ($magang->peserta_didik->count() == $magang->jumlah_peserta)
                                                    {{$magang->jumlah_peserta." peserta"}}
                                                @else
                                                    {{$magang->peserta_didik->count()." dari ".$magang->jumlah_peserta." peserta diusulkan"}}
                                                @endif
                                            </td>
                                            <td class="text-center" style="font-size: 0.85em;">
                                                @php
                                                    $color = "";
                                                    $message = "";
                                                    if ($magang->status == 0) {
                                                        $color = "primary";
                                                        $message = "Diajukan";
                                                    }elseif ($magang->status == 1) {
                                                        $color = "success";
                                                        $message = "Disetujui";
                                                    }elseif ($magang->status == 2) {
                                                        $color = "danger";
                                                        $message = "Ditolak";
                                                    }
                                                @endphp
                                                <span class="badge bg-{{$color}}">{{$message}}</span>
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data permohonan ini?');" action="{{ route('sindikat.permohonan_magang.destroy', $magang->id) }}" method="POST">
                                                    <a href="{{route('sindikat.permohonan_magang.show', $magang->id)}}">
                                                        <button type="button" class="btn btn-primary btn-xs btn-icon">
                                                            <i data-feather="users"></i>
                                                        </button>
                                                    </a>
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $magang->id }}"  data-bs-toggle="modal" data-bs-target="#editRequest">
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
                                            <td colspan="6"><small>Institusi belum memiliki data permohonan magang.</small></td>
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

<div class="modal fade" id="createRequest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Permohonan Magang Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('sindikat.permohonan_magang.store')}}" method="post" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <input type="hidden" name="institusi_id" value="{{$institusi->id}}">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. Surat*</label>
                                    <input type="text" class="form-control" name="no_surat" placeholder="Nomor Surat Permohonan" required>
                                    @error('no_surat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Surat*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_surat" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_surat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Mulai Magang*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_mulai" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_mulai')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Selesai Magang*</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_selesai" data-input required>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                    @error('tanggal_selesai')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jumlah Peserta*</label>
                                    <input type="number" class="form-control" name="jumlah_peserta"  placeholder="Jumlah Peserta Diusulkan" required>
                                    @error('jumlah_peserta')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Dokumen Surat*</label>
                                    <input type="file" name="dokumen" class="form-control"  required>
                                    @error('dokumen')
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



<div class="modal fade" id="editRequest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Detail Permohonan Magang</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRequestForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <iframe id="dokumen_embed" type="application/pdf" width="100%" height="720px"></iframe>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" id="pegawai_id">
                                    <div class="col-md-6 col-sm-12">
                                        <input type="hidden" name="institusi_id" value="{{$institusi->id}}">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. Surat*</label>
                                            <input type="text" class="form-control" name="no_surat" id="no_surat" placeholder="Nomor Surat Permohonan" required>
                                            @error('no_surat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Surat*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tanggal_surat" name="tanggal_surat" data-input required>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tanggal_surat')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Mulai Magang*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" data-input required>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tanggal_mulai')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Selesai Magang*</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" data-input required>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
                                            @error('tanggal_selesai')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jumlah Peserta*</label>
                                            <input type="number" class="form-control" name="jumlah_peserta" id="jumlah_peserta" placeholder="Jumlah Peserta Diusulkan" required>
                                            @error('jumlah_peserta')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Perbarui Dokumen Surat</label>
                                            <input type="file" name="dokumen" class="form-control" id="">
                                            @error('dokumen')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success me-2">Simpan</button>
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
        $('#editRequest').on('show.bs.modal', function(event) {
            // console.log('Oalah');
            var button = $(event.relatedTarget);
            var permohonanId = button.data('id');
            // console.log(permohonanId);

            var url = baseUrl + '/sindikat/permohonan_magang/edit/' + permohonanId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#institusi_id').val(data.institusi_id);
                    $('#no_surat').val(data.no_surat);
                    $('#tanggal_surat').val(data.tanggal_surat);
                    $('#tanggal_mulai').val(data.tanggal_mulai);
                    $('#tanggal_selesai').val(data.tanggal_selesai);
                    $('#jumlah_peserta').val(data.jumlah_peserta);
                    

                    var formAction = "{{ route('sindikat.permohonan_magang.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRequestForm').attr('action', formAction);

                    var embedSrc = baseUrl + '/storage/sindikat/permohonan_magang/' + data.institusi_id + '/' + data.dokumen;
                    $('#dokumen_embed').attr('src', embedSrc);
                    
                },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>