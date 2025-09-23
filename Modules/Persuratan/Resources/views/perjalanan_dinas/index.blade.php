@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

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
        <div class="col-md-12 grid-margin">
            <div class="card rounded">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="ms-2">
                    <h6 class="card-title mb-0">DAFTAR PERMOHONAN PERJALANAN DINAS SAYA</h6>            
                    </div>
                </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-3 middle-wrapper">
                        <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahPermohonan"><i data-feather="plus"></i> TAMBAH PENGAJUAN</button>
                    </div>
                    <div class="col-sm-12 col-md-9 middle-wrapper">
                        <form action="{{ route('persuratan.nomor.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="cari nomor surat">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 middle-wrapper">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">NAMA PERJALANAN DINAS</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">SURAT</th>
                                <th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
    <!-- middle wrapper end -->
</div>

<div class="modal fade" id="tambahPermohonan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Permohonan Perjalanan Dinas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">DASAR PERJALANAN DINAS</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="dasar_surat" placeholder="Masukkan nama surat dasar perjalanan dinas">
                                    @error('dasar_surat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NOMOR SURAT</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nomor_surat" placeholder="Masukkan nomor surat dasar perjalanan">
                                    @error('nomor_surat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TANGGAL SURAT</label>
                                    <input type="date" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tanggal_surat">
                                    @error('tanggal_surat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NAMA PEGAWAI YANG DITUGASKAN</label>
                                    <select name="id_user" class="form-control select2" data-width="100%" required>
                                        <option value="" disabled selected>- Pilih Pegawai -</option>
                                    @foreach ($pegawais as $peg)
                                        <option value="{{$peg->id}}">{{$peg->username." ".$peg->name}}</option>
                                    @endforeach
                                    </select>
                                    @error('id_user')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">KEPERLUAN</label>
                                    <textarea name="keperluan" id="" class="form-control" id="exampleInputUsername1" autocomplete="off" placeholder="Masukkan keperluan perjalanan dinas"></textarea>
                                    @error('keperluan')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TANGGAL BERANGKAT</label>
                                    <input type="date" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tanggal_berangkat">
                                    @error('tanggal_berangkat')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TANGGAL PULANG</label>
                                    <input type="date" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tanggal_pulang">
                                    @error('tanggal_pulang')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">KOTA TUJUAN</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="kota_tujuan" placeholder="Masukkan kota tujuan">
                                    @error('kota_tujuan')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TEMPAT TUJUAN</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tempat_tujuan" placeholder="Masukkan tempat tujuan">
                                    @error('tampat_tujuan')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NAMA DRIVER</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama_driver" placeholder="Masukkan nama diver yang mengantar">
                                    @error('nama_driver')
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

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi select2 pada modal ambilNomor
    $('#tambahPermohonan').on('shown.bs.modal', function () {
        $('.select2').select2({
            dropdownParent: $('#tambahPermohonan') // Ensure the dropdown is appended to the modal
        });
    });

    // Inisialisasi select2 pada modal editNomor
    $('body').on('shown.bs.modal', function (e) {
        var modal = $(e.target);
        modal.find('.select2').select2({
            dropdownParent: modal // Ensure the dropdown is appended to the modal
        });
    });
});
</script>