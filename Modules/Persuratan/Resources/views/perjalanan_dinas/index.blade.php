@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@php
use Illuminate\Support\Str;
use Carbon\Carbon;
@endphp

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Persuratan</li>
        <li class="breadcrumb-item active" aria-current="page">Perjalanan Dinas</li>
    </ol>
</nav>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h5 class="mb-3">PENGAJUAN PERJALANAN DINAS</h5>
                            <select name="surat" class="form-select select2 mb-3" data-width="100%" required>
                                <option value="" disabled selected>-- Pilih Dasar Surat --</option>
                            </select>
                            <select class="js-example-basic-multiple form-select select2" name="pegawai_id[]" multiple="multiple" data-width="100%">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 middle-wrapper">
                                <button type="submit" class="btn btn-xs btn-success" data-bs-toggle="modal" data-bs-target="#tambahSuket"><i data-feather="plus"></i> TAMBAH SUKET</button>
                            </div>
                            <div class="col-sm-12 col-md-9 middle-wrapper">
                                <form method="GET" action="{{ url()->current() }}">
                                    @csrf
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </div>
                                        <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="cari data ...">
                                        <button type="submit" class="btn btn-secondary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 middle-wrapper">
                            <div class="table-responsive">
                                <table class="table table-hover" style="table-layout: fixed; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">KODE KLASIFIKASI</th>
                                            <th class="text-center">NAMA SURAT</th>
                                            <th class="text-center">KEPERLUAN</th>
                                            <th class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada data surat keterangan.</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="pull-right mt-4">
                                    <div class="pull-right mt-4">
                                        <ul class="pagination justify-content-center">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</script>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>

@endpush

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>