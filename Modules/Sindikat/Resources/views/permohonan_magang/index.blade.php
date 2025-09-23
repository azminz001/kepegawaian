@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item active" aria-current="page">Permohonan Magang Institusi</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Permohonan Magang Institusi</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->

    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                <h6 class="card-title mb-0">Data</h6>            
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Institusi</th>
                                        <th>Nomor Surat</th>
                                        <th>Tanggal Surat</th>
                                        <th>Periode Permohonan Magang</th>
                                        <th>JML Peserta</th>
                                        <th>Status</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($permohonan_magangs as $key => $magang)
                                        <tr>
                                            <td scope="row"  style="font-size: 0.85em;">{{ $key + $permohonan_magangs->firstItem() }}</td>
                                            <td  style="font-size: 0.85em;;word-wrap: break-word;white-space: normal;">
                                                {{$magang->institusi->nama}}&nbsp;
                                                <span class="badge bg-primary mt-1">Kota {{$magang->institusi->kota}}</span>
                                            </td>
                                            <td  style="font-size: 0.85em;;word-wrap: break-word;white-space: normal;">
                                                {{$magang->no_surat}}
                                            </td>
                                            <td  style="font-size: 0.85em;;word-wrap: break-word;white-space: normal;">
                                                {{date_format(date_create($magang->tanggal_surat), 'd-M-Y')}}
                                            </td>
                                            <td  style="font-size: 0.85em;">
                                                {{date_format(date_create($magang->tanggal_mulai), 'd-M-Y')}} s.d {{date_format(date_create($magang->tanggal_selesai), 'd-M-Y')}}
                                            </td>
                                            <td class="text-center" style="font-size: 0.85em;">
                                                {{$magang->peserta_didik->count()}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @php
                                                    $color = "";
                                                    $message = "";
                                                    if ($magang->status == 0) {
                                                        $color = "primary";
                                                        $message = "Permohonan Diajukan";
                                                    }elseif ($magang->status == 1) {
                                                        $color = "success";
                                                        $message = "Berkas Diterima";
                                                    }elseif ($magang->status == 2) {
                                                        $color = "warning";
                                                        $message = "Permohonan Dikoordinasikan";
                                                    }elseif ($magang->status == 3) {
                                                        $color = "primary";
                                                        $message = "Dalam Proses";
                                                    }elseif ($magang->status == 4) {
                                                        $color = "success";
                                                        $message = "Permohonan Disetujui";
                                                    }elseif ($magang->status == 5) {
                                                        $color = "danger";
                                                        $message = "Permohonan Ditolak";
                                                    }
                                                @endphp
                                                <span class="badge border border-dark text-dark">{{$message}}</span>
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus Permohonan Magang dengan Nomor {{$magang->nomor_surat}}?');" action="{{ route('sindikat.permohonan_magang.destroy', $magang->id) }}" method="POST">
                                                    <a href="{{route('sindikat.permohonan_magang.show', $magang->id)}}">
                                                        <button type="button" class="btn btn-primary btn-xs btn-icon">
                                                            <i data-feather="eye"></i>
                                                        </button>
                                                    </a>
                                                    @if ($magang->status != '4' && $magang->status != '5')
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus Permohonan {{$magang->nomor_surat}}">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">
                                                <p class="text-danger">Tidak ada data Permohonan Magang dari Institusi.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $permohonan_magangs->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>
                            {{-- <small>Menampilkan {{$users->count()}} data dari total {{$user_count}} Pegawai.</small> --}}

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
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>

  
  
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

