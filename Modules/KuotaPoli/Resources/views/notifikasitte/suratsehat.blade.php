@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">SIMGOS Support</li>
        <li class="breadcrumb-item active" aria-current="page">Surat TTE</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Surat TTE</h3>
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
                                <h6 class="card-title mb-0">Daftar Surat Notifikasi TTE </h6>            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <a href="{{route('simrs_support.send_all_wa')}}">
                                <button type="button" class="btn btn-success" data-toggle="button" aria-pressed="false">
                                    <i class="mdi mdi-whatsapp"></i> Kirim WA Semua Surat
                                </button>
                            </a>
                            <div class="btn-group" role="group">
                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter: Status Sent <i class="mdi mdi-chevron-down"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                    <a class="dropdown-item" href="{{url('arsip_berkas/mdp_tte/0')}}"><small>Sent:</small> <span class="badge rounded-pill border border-danger text-danger">Antrian</span></a>
                                    <a class="dropdown-item" href="{{url('arsip_berkas/mdp_tte/1')}}"><small>Sent:</small> <span class="badge rounded-pill border border-success text-success">Sukses</span></a>
                                </div>
                            </div>
                        </div>
                        <form action="" method="POST">
                            @csrf
                            <div class="d-flex flex-row-reverse">
                                <div class="p-2">
                                    <button type="submit" class="btn btn-success">Cari</button>
                                </div>
                                <div class="p-2">
                                    <input type="text" name="cari" placeholder="No. RM" class="form-control" id="">
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="3%">No</th>
                                        <th>DPJP</th>
                                        <th>Keterangan</th>
                                        <th>Kunjungan</th>
                                        <th>Pasien</th>
                                        <th>REF</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data_surat as $key => $document)
                                        <tr>
                                            <td>{{$data_surat->firstItem() + $key}}</td>
                                            <td>
                                                {{$document->DITTD_OLEH}} <br>
                                                <small>Tanggal TTD: {{$document->DITTD_TANGGAL}}</small>
                                            </td>
                                            <td>
                                                {{$document->KETERANGAN}}
                                            </td>
                                            <td>
                                                {{$document->KUNJUNGAN}}
                                            </td>
                                            <td>
                                                {{$document->NAMA_PASIEN}} <span class="badge rounded-pill border border-danger text-danger">{{$document->NORM}}</span><br>
                                                <small>NIK. <span class="badge rounded-pill border border-primary text-primary">{{$document->NIK}}</span></small>
                                            </td>
                                            <td>
                                                <small>NOPEN. <span class="badge rounded-pill border border-success text-success">{{$document->NOPEN}}</span></small>
                                            </td>
                                            <td>
                                                <a href="{{route('simrs_support.send_wa', $document->ID)}}"><button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="bottom" title="Sinkron Berkas"><i class="mdi mdi-whatsapp"></i></button></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">Belum ada Antrian Surat Sakit</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $data_surat->onEachSide(0)->links('pagination::bootstrap-4') }}
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
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>

@endpush