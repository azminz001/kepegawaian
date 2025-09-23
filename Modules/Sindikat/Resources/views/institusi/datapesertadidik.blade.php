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
        <li class="breadcrumb-item active" aria-current="page">Peserta Didik</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-account-box-outline icon-lg mx-2"></i> Data Peserta Co-Ass/PKL/Magang Institusi</h6>     
                                </div>
                            </div>
                            {{-- <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createRequest">Tambah Permohonan Baru</a>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">No</th>
                                            <th class="text-center" colspan="2">Nama</th>
                                            <th class="text-center">Nomor Induk</th>
                                            <th class="text-center">Jurusan</th>
                                            <th class="text-center">Periode Magang</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($students as $key => $student)
                                        <tr>
                                            <td class="text-center" scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;">
                                                <a href="{{route('sindikat.peserta_didik.show', $student->id)}}">
                                                    {{$student->nama_lengkap}}
                                                </a>
                                            </td>
                                            <td  style="font-size: 0.85em" class="text-center"><span class="mdi mdi-gender-{{$student->jenis_kelamin == 0 ? 'male':'female'}}"></span></td>
                                            <td style="font-size: 0.85em;">
                                                {{$student->no_induk}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$student->nama_jurusan}}
                                            </td>
                                            <td class="text-center" style="font-size: 0.85em;">
                                                {{date_format(date_create($student->tanggal_mulai), 'd-M-Y')}} s.d {{date_format(date_create($student->tanggal_selesai), 'd-M-Y')}}
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data peserta ini?');" action="{{ route('sindikat.peserta_didik.destroy', $student->id) }}" method="POST">
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
                                            <td colspan="6"><small>Institusi belum memiliki data peserta Co-Ass/PKL/Magang.</small></td>
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