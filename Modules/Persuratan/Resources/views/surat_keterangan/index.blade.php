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
        <li class="breadcrumb-item active" aria-current="page">Master Surat Keterangan</li>
    </ol>
</nav>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
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
                                        @forelse ($suket as $item)
                                        <tr>
                                            <td style="font-size: 0.85em;">{{ $item->kode }}</td>
                                            <td style="font-size: 0.85em;">{{ $item->nama_suket }}</td>
                                            <td style="font-size: 0.85em;">{{ $item->keperluan }}</td>
                                            <td style="font-size: 0.85em;">
                                                <div class="d-inline-flex gap-1">
                                                    <button type="submit" class="btn btn-xs btn-default btn-icon" data-bs-toggle="modal" data-bs-target="#editSuket{{ $item->id_suket }}"><i data-feather="eye"></i></button>

                                                    <form onsubmit="return confirm('Apakah Anda yakin menghapus {{ $item->nama_suket }} {{ $item->keperluan }} ini?');"
                                                        action="{{ route('persuratan.surat_keterangan.destroy', $item->id_suket) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-xs btn-icon" data-bs-toggle="tooltip" title="Hapus">
                                                            <i data-feather="trash-2"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada data surat keterangan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="pull-right mt-4">
                                    <div class="pull-right mt-4">
                                        <ul class="pagination justify-content-center">
                                            {{ $suket->onEachSide(0)->links('pagination::bootstrap-4') }}
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

    <div class="modal fade" id="tambahSuket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">DATA SURAT KETERANGAN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="{{route('persuratan.surat_keterangan.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">KLASIFIKASI SURAT</label>
                                    <select name="id_klasifikasi" class="form-control select2" data-width="100%" required>
                                        <option value="" disabled selected>- Pilih Klasifikasi -</option>
                                        @foreach ($klasifikasi as $klas)
                                        <option value="{{$klas->id}}">{{$klas->kode." ".$klas->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('klasifikasi')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NAMA SURAT</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="exampleInputUsername1" autocomplete="off" name="nama_suket" placeholder="masukkan nama surat" required>
                                    @error('nama_surat')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">ISI SURAT</label>
                                    <textarea class="form-control" autocomplete="off" name="isi" id="exampleInputUsername1" placeholder="masukkan isi surat" required></textarea>
                                    @error('isi_surat')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">KEPERLUAN</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" id="exampleInputUsername1" autocomplete="off" name="keperluan" value="" placeholder="masukkan keperluan surat" required>
                                    @error('nama_surat')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-success">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($suket as $item)
    <div class="modal fade" id="editSuket{{ $item->id_suket }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">DETAIL DATA SURAT KETERANGAN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <form action="{{ route('persuratan.surat_keterangan.update', $item->id_suket) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">KLASIFIKASI SURAT</label>
                                    <select name="id_klasifikasi" class="form-control select2" data-width="100%" required>
                                        <option value="{{ $item->id_klasifikasi }}" selected>{{ $item->kode }}</option>
                                        @foreach ($klasifikasi as $klas)
                                        <option value="{{$klas->id}}">{{$klas->kode." ".$klas->nama}}</option>
                                        @endforeach
                                    </select>
                                    @error('id_klasifikasi')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NAMA SURAT</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama_suket" value="{{$item->nama_suket}}" style="text-transform: uppercase;" required>
                                    @error('nama_suket')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">ISI SURAT</label>
                                    <textarea class="form-control" id="exampleInputUsername1" autocomplete="off" name="isi_suket" required>{{$item->isi}}</textarea>
                                    @error('isi_suket')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">KEPERLUAN</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="keperluan" value="{{$item->keperluan}}" style="text-transform: uppercase;" required>
                                    @error('keperluan')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-success">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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

    <script>
        $(document).ready(function() {
            $('#tambahSuket').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $('#tambahSuket') // Ensure the dropdown is appended to the modal
                });
            });

            $('body').on('shown.bs.modal', function(e) {
                var modal = $(e.target);
                modal.find('.select2').select2({
                    dropdownParent: modal // Ensure the dropdown is appended to the modal
                });
            });
        });
    </script>