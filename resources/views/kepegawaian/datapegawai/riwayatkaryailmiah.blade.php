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
        <li class="breadcrumb-item active" aria-current="page">Data Riwayat Karya Ilmiah Pegawai</li>
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
                                    <h6 class="card-title mb-0"><i class="mdi mdi-chemical-weapon icon-lg mx-2"></i> Data Riwayat Karya Ilmiah</h6>     
                                </div>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createKaryaIlmiah">Tambah Karya Ilmiah Baru</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h6 class="card-title mb-2">Riwayat Publikasi Artikel/Jurnal</h6>
                            <div class="table-responsive mb-2">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="" width="5%">No</th>
                                            <th class="">Judul Artikel/Jurnal</th>
                                            <th class="">Nama Jurnal</th>
                                            <th class="text-center">Volume</th>
                                            <th class="">Link</th>
                                            <th class="text-center" width="10%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayat_artikels as $key => $artikel)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$artikel->judul_artikel}} <br />
                                                <span class="badge rounded-pill border border-primary text-primary mt-2">{{($artikel->doi != null) ? "DOI: ".$artikel->doi:""}}</span>
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$artikel->nama_jurnal}}<br/>
                                                <span class="badge rounded-pill border border-success text-success mt-2">{{($artikel->scope != null) ? "Scope/Focus: ".$artikel->scope:""}}</span>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$artikel->volume}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @if ($artikel->link != null)
                                                <a href="{{$artikel->link}}" target="_blank">Buka Jurnal</a>
                                                @else
                                                <span>No Link</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data artikel atau jurnal {{$artikel->judul_artikel}}?');" action="{{ route('riwayat_artikel.destroy', $artikel->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $artikel->id }}"  data-bs-toggle="modal" data-bs-target="#editArtikel">
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
                                        <tr>
                                            <td colspan="6"><small>Tidak memiliki data publikasi artikel atau jurnal.</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="card-title mb-2 mt-4">Riwayat Penerbitan Buku</h6>
                            <div class="table-responsive mb-2">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="" width="5%">No</th>
                                            <th class="">Judul Buku</th>
                                            <th class="">Halaman</th>
                                            <th class="text-center">Penerbit</th>
                                            <th class="">Link</th>
                                            <th class="text-center" width="10%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($riwayat_karyabukus as $key => $buku)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$buku->judul}} <br />
                                                <span class="badge rounded-pill border border-primary text-primary mt-2">{{($buku->isbn != null) ? "ISBN: ".$buku->isbn:""}}</span>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$buku->halaman}}
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$buku->penerbit}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @if ($buku->link != null)
                                                <a href="{{$buku->link}}" target="_blank">Buka Buku</a>
                                                @else
                                                <span>No Link</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data buku {{$buku->judul}}?');" action="{{ route('riwayat_buku.destroy', $buku->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $buku->id }}"  data-bs-toggle="modal" data-bs-target="#editBuku">
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
                                        <tr>
                                            <td colspan="6"><small>Tidak memiliki data penerbitan buku.</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="card-title mb-2 mt-4">Riwayat Inovasi</h6>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="" width="5%">No</th>
                                            <th class="">Judul Inovasi</th>
                                            <th class="">Tahun</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center" width="10%">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($riwayat_inovasis as $key => $inovasi)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$inovasi->judul}} <br />
                                                <span class="badge rounded-pill border border-primary text-primary mt-2"> Jenis Inovasi: {{$inovasi->jenis}}</span>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$inovasi->tahun}}
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$inovasi->keterangan}}
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus data inovasi {{$inovasi->judul}}?');" action="{{ route('riwayat_inovasi.destroy', $inovasi->id) }}" method="POST">
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $inovasi->id }}"  data-bs-toggle="modal" data-bs-target="#editInovasi">
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
                                            <td colspan="6"><small>Tidak memiliki data inovasi</small></td>
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

<div class="modal fade" id="createKaryaIlmiah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Anak Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="artikel-line-tab" data-bs-toggle="tab" href="#artikel" role="tab" aria-controls="artikel" aria-selected="true">Artikel / Jurnal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="buku-line-tab" data-bs-toggle="tab" href="#buku" role="tab" aria-controls="buku" aria-selected="false">Buku</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="inovasi-line-tab" data-bs-toggle="tab" href="#inovasi" role="tab" aria-controls="inovasi" aria-selected="false">Inovasi</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="lineTabContent">
                        <div class="tab-pane fade show active" id="artikel" role="tabpanel" aria-labelledby="artikel-line-tab">
                            <form action="{{route('riwayat_artikel.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Judul Artikel</label>
                                            <input type="text" class="form-control" name = "judul_artikel" placeholder="Judul Artikel/Jurnal" id="">
                                            @error('judul_artikel')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">DOI</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" name="doi" placeholder="DOI Number">
                                            @error('doi')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Publikasi Jurnal</label>
                                            <input type="text" name="nama_jurnal" class="form-control" placeholder="Nama Publikasi Jurnal Nasional / Internasional" id="">
                                            @error('tanggal_lulus')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Scope/Focus</label>
                                            <input type="text" class="form-control" name="scope" placeholder="Kesehatan/Ekonomi/Manajemen/Teknologi">
                                            @error('scope')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Volume</label>
                                            <input class="form-control" name="volume" placeholder="Vol. 5 No. 2 (2024): Januari">
                                            @error('nama_sekolah_pt')
                                            <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Link / URL</label>
                                            <input class="form-control" name="link" placeholder="Tempel Link/Url Publikasi Jurnal">
                                            @error('link')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success me-2">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="buku" role="tabpanel" aria-labelledby="buku-line-tab">
                            <form action="{{route('riwayat_buku.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Judul Buku</label>
                                            <input type="text" name="judul" class="form-control" placeholder="Judul Buku" id="">
                                            @error('judul')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">ISBN</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" name="isbn" placeholder="ISBN">
                                            @error('isbn')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jumlah Halaman</label>
                                            <input type="number" name="halaman" class="form-control" placeholder="Jumlah Halaman" id="">
                                            @error('tanggal_lulus')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Penerbit</label>
                                            <input type="text" class="form-control" name="penerbit" placeholder="Nama Penerbit">
                                            @error('penerbit')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Link / URL</label>
                                            <input class="form-control" name="link" placeholder="Tempel Link/URL Buku / Identitas Buku dari situs isbn.perpusnas.go.id">
                                            @error('link')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success me-2">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="inovasi" role="tabpanel" aria-labelledby="inovasi-line-tab">
                            <form action="{{route('riwayat_inovasi.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Judul Inovasi</label>
                                            <input type="text" name="judul" class="form-control" placeholder="Judul Inovasi" id="">
                                            @error('judul')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tahun</label>
                                            <input type="number" class="form-control" id="" name="tahun" placeholder="Tahun">
                                            @error('tahun')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jenis Inovasi</label>
                                            <input type="text" name="jenis" class="form-control" placeholder="Perangkat Lunak/Alat Bantu/IoT/dll" id="">
                                            @error('jenis')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Keterangan</label>
                                            <textarea name="keterangan" class="form-control" id="" cols="30" rows="5" placeholder="Penjelasan singkat tentang Inovasi yang dibuat"></textarea>
                                            @error('keterangan')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success me-2">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editArtikel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editArtikelForm" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Judul Artikel</label>
                                    <input type="text" class="form-control" name = "judul_artikel" placeholder="Judul Artikel/Jurnal" id="judul_artikel">
                                    @error('judul_artikel')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">DOI</label>
                                    <input type="text" class="form-control" name="doi" id="doi" placeholder="DOI Number">
                                    @error('doi')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Publikasi Jurnal</label>
                                    <input type="text" name="nama_jurnal" class="form-control" placeholder="Nama Publikasi Jurnal Nasional / Internasional" id="nama_jurnal">
                                    @error('tanggal_lulus')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Scope/Focus</label>
                                    <input type="text" class="form-control" id="scope" name="scope" placeholder="Kesehatan/Ekonomi/Manajemen/Teknologi">
                                    @error('scope')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Volume</label>
                                    <input class="form-control" id="volume" name="volume" placeholder="Vol. 5 No. 2 (2024): Januari">
                                    @error('nama_sekolah_pt')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Link / URL</label>
                                    <input class="form-control" name="link" id="link_artikel" placeholder="Tempel Link/Url Publikasi Jurnal">
                                    @error('link')
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

<div class="modal fade" id="editBuku" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data Karya Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editBukuForm" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Judul Buku</label>
                                    <input type="text" name="judul" class="form-control" placeholder="Judul Buku" id="judul">
                                    @error('judul')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="ISBN">
                                    @error('isbn')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jumlah Halaman</label>
                                    <input type="number" name="halaman" class="form-control" placeholder="Jumlah Halaman" id="halaman">
                                    @error('tanggal_lulus')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Penerbit</label>
                                    <input type="text" class="form-control" name="penerbit" id="penerbit" placeholder="Nama Penerbit">
                                    @error('penerbit')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Link / URL</label>
                                    <input class="form-control" name="link" id="link_buku" placeholder="Tempel Link/URL Buku / Identitas Buku dari situs isbn.perpusnas.go.id">
                                    @error('link')
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

<div class="modal fade" id="editInovasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data Karya Inovasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editInovasiForm" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <input type="hidden" name="pegawai_id" value="{{$pegawai->id}}">
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Judul Inovasi</label>
                                    <input type="text" name="judul" class="form-control" placeholder="Judul Inovasi" id="judul_inovasi">
                                    @error('judul')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tahun</label>
                                    <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun">
                                    @error('tahun')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Inovasi</label>
                                    <input type="text" name="jenis" class="form-control" placeholder="Perangkat Lunak/Alat Bantu/IoT/dll" id="jenis">
                                    @error('jenis')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="5" placeholder="Penjelasan singkat tentang Inovasi yang dibuat"></textarea>
                                    @error('keterangan')
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
        $('#editArtikel').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var artikelId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_artikel/edit/' + artikelId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#judul_artikel').val(data.judul_artikel);
                    $('#doi').val(data.doi);
                    $('#nama_jurnal').val(data.nama_jurnal);
                    $('#scope').val(data.scope);
                    $('#volume').val(data.volume);
                    $('#link_artikel').val(data.link);

                    var formAction = "{{ route('riwayat_artikel.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editArtikelForm').attr('action', formAction);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
        $('#editBuku').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var bukuId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_buku/edit/' + bukuId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#judul').val(data.judul);
                    $('#isbn').val(data.isbn);
                    $('#halaman').val(data.halaman);
                    $('#penerbit').val(data.penerbit);
                    $('#link_buku').val(data.link);

                    var formAction = "{{ route('riwayat_buku.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editBukuForm').attr('action', formAction);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
        $('#editInovasi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var inovasiId = button.data('id');
            var url = baseUrl + '/kepegawaian/riwayat_inovasi/edit/' + inovasiId;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#pegawai_id').val(data.pegawai_id);
                    $('#judul_inovasi').val(data.judul);
                    $('#tahun').val(data.tahun);
                    $('#jenis').val(data.jenis);
                    $('#keterangan').val(data.keterangan);

                    var formAction = "{{ route('riwayat_inovasi.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editInovasiForm').attr('action', formAction);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>