@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">WhatsApp API</li>
        <li class="breadcrumb-item active" aria-current="page">Catatan</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Catatan Pengiriman WhatsApp</h3>

<div class="row">
    <div class="col-md-8 grid-margin">
        <div class="card rounded">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="ms-2">
                        <h6 class="card-title mb-0">Data Catatan</h6>            
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p>100 data catatan pengiriman terbaru</p>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>Jenis</th>
                                <th>Tujuan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $key => $log)
                                <tr>
                                    <td scope="row">{{$key+1}}</td>
                                    <td>
                                        {{$log->created_at}} 
                                    </td>
                                    <td>
                                        {{$log->jenis}}
                                    </td>
                                    <td>{{$log->catatan}}</td>
                                    <td>{{$log->status == 1 ? 'Terkirim':'Gagal'}}</td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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