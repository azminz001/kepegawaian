@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">WhatsApp API</li>
        <li class="breadcrumb-item active" aria-current="page">Perangkat</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Perangkat Terhubung</h3>
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
                                <h6 class="card-title mb-0">Daftar Perangkat</h6>            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="dataTableExample">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Device ID</th>
                                        <th>Device Nama</th>
                                        <th>Nomor HP</th>
                                        <th>Status Perangkat</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($devices as $key => $device)
                                        <tr>
                                            <td scope="row">{{$key+1}}</td>
                                            <td>
                                                {{$device->device_id}} <br>
                                                @php
                                                    $url = "https://dash.whacenter.id/api/statusDevice?device_id=" . $device->device_id;

                                                    $ch = curl_init($url);
                                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                                                    $response = curl_exec($ch);
                                                    curl_close($ch);
                                                    $result = json_decode($response, true);

                                                    if (isset($result['status']) && $result['status'] === true && isset($result['data']['status']) && $result['data']['status'] === "CONNECTED") {
                                                        echo "<span class='text-success'>WhaCenter Connected </span>";
                                                    } else {
                                                        echo "<span class='text-danger'>WhaCenter Not Connected </span>";
                                                    }
                                                @endphp

                                            </td>
                                            <td>
                                                {{$device->device_name}}
                                            </td>
                                            <td>{{$device->nomor_hp}}</td>
                                            <td>{{$device->status == 1 ? 'Aktif':'Tidak Aktif'}}</td>
                                            <td>
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus perangkat {{$device->device_name}}?');" action="{{ route('sindikat.kategori.destroy', $device->id) }}" method="POST">
                                                    <button type="button" class="btn btn-primary btn-xs btn-icon"  data-bs-toggle="modal" data-bs-target="#editCategory{{$device->id}}">
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


@foreach ($devices as $device)
<div class="modal fade" id="editCategory{{$device->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Perangkat</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('whatsappapi.device.update', $device->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group mb-3">
                      <label for="">Device ID</label>
                      <input type="text" name="device_id" value="{{$device->device_id}}" id="" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group mb-3">
                      <label for="">Device Nama</label>
                      <input type="text" name="device_name" value="{{$device->device_name}}" id="" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group mb-3">
                      <label for="">Nomor HP</label>
                      <input type="text" name="nomor_hp" value="{{$device->nomor_hp}}" id="" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group mb-3">
                      <label for="">Status Perangkat</label>
                      <select name="status" id="" class="form-control">
                        <option value="0" {{ $device->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="1" {{ $device->status == 1 ? 'selected' : '' }}> Aktif</option>
                      </select>
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

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