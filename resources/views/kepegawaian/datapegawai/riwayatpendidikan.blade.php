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
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item" aria-current="page">Pegawai</li>
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Pendidikan Pegawai</li>
    </ol>
</nav>
<h4 class="page-title mb-4">{{($pegawai->gelar_depan!=null)? $pegawai->gelar_depan.". ":""}}{{$pegawai->nama}}{{($pegawai->gelar_belakang!=null)?", ".$pegawai->gelar_belakang:""}} <small class="text-muted">{{$pegawai->nip_nipppk_nrpk_nrpblud}}</small></h4> 
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-3 grid-margin">
        @include('kepegawaian.datapegawai.sidebar_pegawai')
    </div>
    <div class="col-sm-12 col-md-9 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0"><i class="mdi mdi-school icon-lg mx-2"></i> Data Riwayat Pendidikan Pegawai</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createPendidikanPegawai">Tambah Pendidikan Pegawai</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="">No</th>
                                            <th class="text-center">Jenjang</th>
                                            <th class="text-center">Nomor Ijazah</th>
                                            <th class="text-center">Tanggal Lulus</th>
                                            <th class="text-center">Sekolah / Perguruan Tinggi</th>
                                            <th class="text-center">Pendidkan Terakhir</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($riwayat_pendidikans as $key => $riwayat_pendidikan)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td class="text-center" style="font-size: 0.85em;">
                                                {{$riwayat_pendidikan->jenjang_pendidikan->nama}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_pendidikan->nomor_ijazah}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{date('d-M-Y', strtotime($riwayat_pendidikan->tanggal_lulus))}}

                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_pendidikan->nama_sekolah_pt}}
                                                <p class="mt-1"><small>{{$riwayat_pendidikan->jurusan}}</small></p>
                                            </td>
                                            <?php
                                                $warna = "";
                                                $icon  = "";
                                                if($riwayat_pendidikan->is_pendidikan_terakhir == 1){
                                                    $warna = "success";
                                                    $icon = "check";
                                                }else{
                                                    $warna = "danger";
                                                    $icon = "x";
                                                }
                                                
                                            ?>
                                            <td class="text-center" style="font-size: 0.85em;"><span data-feather="{{$icon}}-circle" class="text-{{$warna}}"></span></td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus riwayat pendidikan ini?');" action="{{ route('riwayat_pendidikan.destroy', $riwayat_pendidikan->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{$riwayat_pendidikan->id}}" data-bs-toggle="modal" data-bs-target="#editRiwayatPendidikan">
                                                        <i data-feather="eye"></i>
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
                                            <td colspan="7"><small>Tidak ada data Riwayat Pendidikan Pegawai</small></td>
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

<div class="modal fade" id="createPendidikanPegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Riwayat Pendidikan Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="container">
                        <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="umum-line-tab" data-bs-toggle="tab" href="#umum" role="tab" aria-controls="umum" aria-selected="true">Pendidikan Umum</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tinggi-line-tab" data-bs-toggle="tab" href="#tinggi" role="tab" aria-controls="tinggi" aria-selected="false">Pendidikan Tinggi</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="lineTabContent">
                            <div class="tab-pane fade show active" id="umum" role="tabpanel" aria-labelledby="umum-line-tab">
                                <form action="{{route('riwayat_pendidikan.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Jenjang Pendidikan</label>
                                                <select name="jenjang_pendidikan_id" id="" class="form-control select2">
                                                    <option value="">- Pilih Jenjang Pendidikan -</option>
                                                    @foreach ($jenjang_umum_pendidikans as $jenjang)
                                                        <option value="{{$jenjang->id}}">{{$jenjang->nama}}</option>
                                                    @endforeach
                                                </select>
                                                @error('jenjang_pendidikan_id')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">No. Ijazah</label>
                                                <input type="text" class="form-control" id="exampleInputUsername1" name="nomor_ijazah" placeholder="Nomor Ijazah">
                                                @error('nomor_ijazah')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tanggal Lulus</label>
                                                <div class="input-group flatpickr" id="flatpickr-date">
                                                    <input type="text" class="form-control" name="tanggal_lulus" data-input>
                                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                </div> 
                                                @error('tanggal_lulus')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tahun Lulus</label>
                                                <input type="number" class="form-control" name="tahun_lulus" placeholder="Tahun Lulus">
                                                @error('tahun_lulus')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Sekolah</label>
                                                <input class="form-control" name="nama_sekolah_pt" placeholder="Nama Sekolah">
                                                @error('nama_sekolah_pt')
                                                <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Kepala Sekolah</label>
                                                <input class="form-control" name="kepala" placeholder="Nama Kepala Sekolah">
                                                @error('kepala')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Jurusan</label>
                                                <input class="form-control" name="jurusan" placeholder="Jurusan ">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Dokumen Ijazah</label>
                                                <input type="file" class="form-control" name="dokumen_ijazah" accept = "application/pdf">
                                                @error('dokumen_ijazah')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Dokumen Nilai</label>
                                                <input type="file" class="form-control" name="dokumen_nilai" accept = "application/pdf">
                                                @error('dokumen_nilai')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="alert alert-info" role="alert">
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="is_pendidikan_terakhir" value="1" class="form-check-input" id="checkInline1">
                                                    <label class="form-check-label" for="checkInline1">
                                                    Konfirmasi Pendidikan terakhir Anda saat ini
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="tinggi" role="tabpanel" aria-labelledby="tinggi-line-tab">
                                <form action="{{route('riwayat_pendidikan.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Jenjang Pendidikan</label>
                                                <select name="jenjang_pendidikan_id" id="" class="form-control select2" style="width: 100%">
                                                    <option value="">- Pilih Jenjang Pendidikan -</option>
                                                    @foreach ($jenjang_tinggi_pendidikans as $jenjang)
                                                        <option value="{{$jenjang->id}}">{{$jenjang->nama}}</option>
                                                    @endforeach
                                                </select>
                                                @error('jenjang_pendidikan_id')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">No. Ijazah</label>
                                                <input type="text" class="form-control" id="exampleInputUsername1" name="nomor_ijazah" placeholder="Nomor Ijazah">
                                                @error('nomor_ijazah')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tanggal Lulus</label>
                                                <div class="input-group flatpickr" id="flatpickr-date">
                                                    <input type="text" class="form-control" name="tanggal_lulus" data-input>
                                                    <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                </div> 
                                                @error('tanggal_lulus')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Tahun Lulus</label>
                                                <input type="number" class="form-control" name="tahun_lulus" placeholder="Tahun Lulus">
                                                @error('tahun_lulus')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Gelar Depan</label>
                                                <input class="form-control" name="gelar_depan" placeholder="Gelar Depan">
                                                @error('gelar_depan')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Gelar Belakang</label>
                                                <input class="form-control" name="gelar_belakang" placeholder="Gelar Belakang">
                                                @error('gelar_belakang')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Perguruan Tinggi</label>
                                                <input class="form-control" name="nama_sekolah_pt" placeholder="Nama Sekolah">
                                                @error('nama_sekolah_pt')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Rektor/Direktur</label>
                                                <input class="form-control" name="kepala" placeholder="Nama Kepala">
                                                @error('kepala')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Program Studi</label>
                                                <input class="form-control" name="jurusan" placeholder="Program Studi">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Dokumen Ijazah</label>
                                                <input type="file" class="form-control" name="dokumen_ijazah" accept = "application/pdf">
                                                @error('dokumen_ijazah')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Dokumen Nilai</label>
                                                <input type="file" class="form-control" name="dokumen_nilai" accept = "application/pdf">
                                                @error('dokumen_nilai')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="alert alert-info" role="alert">
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" name="is_pendidikan_terakhir" value="1" class="form-check-input" id="checkInline1">
                                                    <label class="form-check-label" for="checkInline1">
                                                    Konfirmasi Pendidikan terakhir Anda saat ini
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editRiwayatPendidikan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Detail Riwayat Pendidikan Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRiwayatPendidikanForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                                    <li class="nav-item">
                                      <a class="nav-link active" id="home-line-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Ijazah</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link" id="profile-line-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Nilai</a>
                                    </li>
                                  </ul>
                                  <div class="tab-content mt-3" id="lineTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-line-tab">
                                        <iframe id="dokumen_ijazah_embed" type="application/pdf" width="100%" height="720px"></iframe>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">
                                        <iframe id="dokumen_nilai_embed" type="application/pdf" width="100%" height="720px"></iframe>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" id="pegawai_id">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jenjang Pendidikan</label> <br>
                                            <select name="jenjang_pendidikan_id" id="jenjang_pendidikan_id" class="form-control select2" style="width:100%">
                                            </select>
                                            @error('jenjang_pendidikan_id')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. Ijazah</label>
                                            <input type="text" class="form-control" name="nomor_ijazah" id="nomor_ijazah" placeholder="Nomor Ijazah">
                                            @error('nomor_ijazah')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Lulus</label>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <input type="text" class="form-control" name="tanggal_lulus" id="tanggal_lulus" data-input>
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div> 
                                            @error('tanggal_lulus')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tahun Lulus</label>
                                            <input type="number" class="form-control" name="tahun_lulus" id="tahun_lulus" placeholder="Tahun Lulus">
                                            @error('tahun_lulus')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Gelar Depan</label>
                                            <input class="form-control" name="gelar_depan" id="gelar_depan" placeholder="Gelar Depan">
                                            @error('gelar_depan')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Gelar Belakang</label>
                                            <input class="form-control" name="gelar_belakang" id="gelar_belakang" placeholder="Gelar Belakang">
                                            @error('gelar_belakang')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Sekolah</label>
                                            <input class="form-control" name="nama_sekolah_pt" id="nama_sekolah_pt" placeholder="Nama Sekolah">
                                            @error('nama_sekolah_pt')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Kepala Sekolah</label>
                                            <input class="form-control" name="kepala" id="kepala" placeholder="Nama Kepala Sekolah">
                                            @error('kepala')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jurusan/Program Studi</label>
                                            <input class="form-control" name="jurusan" id="jurusan" placeholder="Jurusan / Program Studi">
                                            @error('jurusan')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Ganti Dokumen Ijazah</label>
                                            <input type="file" class="form-control" name="dokumen_ijazah" accept = "application/pdf">
                                            @error('dokumen_ijazah')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Ganti Dokumen Nilai</label>
                                            <input type="file" class="form-control" name="dokumen_nilai" accept = "application/pdf">
                                            @error('dokumen_nilai')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="alert alert-info" role="alert">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" name="is_pendidikan_terakhir" id="is_pendidikan_terakhir" class="form-check-input" value="1">
                                                <label class="form-check-label" for="is_jabatan_terakhir">
                                                    Konfirmasi Pendidikan terakhir Anda saat ini
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success me-2">Simpan Perubahan</button>
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
    $('#createPendidikanPegawai').on('shown.bs.modal', function () {
        $('.select2').select2({
            dropdownParent: $('#createPendidikanPegawai') // Ensure the dropdown is appended to the modal
        });
    });
});
</script>
<script>
    $(document).ready(function() {
        var baseUrl = '{{ url('/') }}';
        $('#editRiwayatPendidikan').on('show.bs.modal', function(event) {
            $('.select2').select2({
                dropdownParent: $('#editRiwayatPendidikan') // Ensure the dropdown is appended to the modal
            });
            var button = $(event.relatedTarget);
            var riwayatPendidikanId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_pendidikan/edit/' + riwayatPendidikanId;
            
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#nomor_ijazah').val(data.nomor_ijazah);
                    $('#tanggal_lulus').val(data.tanggal_lulus);
                    $('#tahun_lulus').val(data.tahun_lulus);
                    $('#gelar_depan').val(data.gelar_depan);
                    $('#gelar_belakang').val(data.gelar_belakang);
                    $('#nama_sekolah_pt').val(data.nama_sekolah_pt);
                    $('#jurusan').val(data.jurusan);
                    $('#kepala').val(data.kepala);

                    // Populate Jenjang Pendidikan Select2
                    $.ajax({
                        url: baseUrl + '/kepegawaian/jenjang_pendidikans',
                        method: 'GET',
                        success: function(jenjang_pendidikans) {
                            $('#jenjang_pendidikan_id').empty().select2({
                                data: jenjang_pendidikans.map(function(jenjang_pendidikan) {
                                    return {
                                        id: jenjang_pendidikan.id,
                                        text: jenjang_pendidikan.nama
                                    };
                                })
                            }).val(data.jenjang_pendidikan_id).trigger('change');
                        }
                    });

                    $('#pegawai_id').val(data.pegawai_id);
                    $('#is_pendidikan_terakhir').prop('checked', data.is_pendidikan_terakhir == 1);

                    var formAction = "{{ route('riwayat_pendidikan.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRiwayatPendidikanForm').attr('action', formAction);

                    var embedIjazahSrc = baseUrl + '/storage/dokumen_pegawai/' + data.pegawai_id + '/' + data.dokumen_ijazah;
                    $('#dokumen_ijazah_embed').attr('src', embedIjazahSrc);
                    var embedNilaiSrc = baseUrl + '/storage/dokumen_pegawai/' + data.pegawai_id + '/' + data.dokumen_nilai;
                    $('#dokumen_nilai_embed').attr('src', embedNilaiSrc);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>