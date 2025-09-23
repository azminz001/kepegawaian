@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item active" aria-current="page">Unit RSUD</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Pegawai [{{$unit->nama}}]</h3>
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
                                    <h6 class="card-title mb-0">Data</h6>            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('data_pegawai.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="btn-icon-prepend" data-feather="search"></i>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Nama atau Nomor Induk Pegawai">
                                <button type="submit" class="btn btn-secondary btn-icon-text" style="margin-right: 14px">Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            {{-- {{dump($kel_jabatan->pegawai_aktif)}} --}}
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th>Nama</th>
                                        <th>Kontak Pribadi</th>
                                        <th>Jabatan Unit</th>
                                        <th>Jabatan Pegawai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pegawais as $key => $pegawai)
                                        <tr>
                                            <td scope="row">{{ $key + $pegawais->firstItem() }}</td>
                                            <td>
                                                @if ($pegawai->foto == null)
                                                    <img src="{{ asset('assets/images/user-icon.png') }}" class="rounded-circle" style="width: 55px;height:55px" alt="" srcset="">
                                                @else
                                                    <div class="me-3">
                                                        <img src="{{ asset('storage/foto_pegawai/'.$pegawai->nip_nipppk_nrpk_nrpblud.'/'.$pegawai->foto) }}" class="rounded-circle" style="width: 55px;height:55px;object-fit: cover" alt="...">
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{url('kepegawaian/data_pegawai/show/'.$pegawai->pegawai_id)}}">
                                                    {{($pegawai->gelar_depan!=null)? $pegawai->gelar_depan.". ":""}}{{$pegawai->nama_pegawai}}{{($pegawai->gelar_belakang!=null)?", ".$pegawai->gelar_belakang:""}}
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
                                            <td class="">
                                                Email: {{$pegawai->email}} <br>
                                                No. HP : {{$pegawai->no_hp}}
                                            </td>
                                            <td>
                                                @if($pegawai->nama_jabatan_unit)
                                                    {{ $pegawai->nama_jabatan_unit }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($pegawai->nama_jabatan)
                                                    <strong>{{$pegawai->nama_kel_jabatan}}</strong><br>
                                                    {{ $pegawai->nama_jabatan }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $pegawais->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
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