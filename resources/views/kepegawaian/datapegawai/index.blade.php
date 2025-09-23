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
        <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Pegawai</h3>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Jumlah Pegawai</h6>
                    </div>
                    <div class="row">
                        <div class="col-9 col-md-12 col-xl-">
                            <div class="row mt-3">
                                <div class="col-9">
                                    <h5 class="text-success">PNS</h5>
                                </div>
                                <div class="col-3">
                                    <h5 class="mb-2 text-success">: {{$jml_pns}}</h5>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-9">
                                    <h5 class="text-danger">PPPPK</span></h5>
                                </div>
                                <div class="col-3">
                                    <h5 class="mb-2 text-danger">: {{$jml_pppk}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">TENAGA BLUD</h6>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2 mt-3">{{$jml_blud}}</h3>
                            <div class="d-flex align-items-baseline">
                                <p class="text-primary">
                                    <span>Pegawai</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">TENAGA MITRA</h6>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2 mt-3">{{$jml_mitra}}</h3>
                            <div class="d-flex align-items-baseline">
                                <p class="text-primary">
                                    <span>Pegawai</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">TENAGA KONTRAK</h6>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-12 col-xl-5">
                            <h3 class="mb-2 mt-3">{{$jml_kontrak}}</h3>
                            <div class="d-flex align-items-baseline">
                                <p class="text-primary">
                                    <span>Pegawai</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->
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
                                    <h6 class="card-title mb-0">Data Pegawai RSUD Brebes</h6>            
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <button class="btn btn-success btn-icon-text" data-bs-toggle="modal" data-bs-target="#createPegawai"><i class="btn-icon-prepend" data-feather="user-plus"></i>Tambah Pegawai Baru</button>
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
                                <div class="dropdown">
                                    <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="show">
                                        <button type="submit" class="btn btn-primary btn-icon-text"><i class="btn-icon-prepend" data-feather="filter"></i>Tampilkan</button>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" data-popper-placement="top-end" style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate3d(0px, -22.8571px, 0px);">
                                        <a class="dropdown-item d-flex align-items-center" href="{{route('data_pegawai.filter', 'aktif')}}"><i class="btn-icon-prepend icon-sm mx-2" data-feather="user-check"></i><span class=""> Aktif</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="{{route('data_pegawai.filter', 'tidak_aktif')}}"><i class="mdi mdi-account-off icon-sm mx-2"></i><span class=""> Tidak Aktif</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="{{route('data_pegawai.filter', 'mutasi')}}"><i class="mdi mdi-account-multiple-outline icon-sm mx-2"></i><span class=""> Mutasi</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="{{route('data_pegawai.filter', 'pensiun')}}"><i class="btn-icon-prepend icon-sm mx-2" data-feather="heart"></i><span class=""> Pensiun</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="{{route('data_pegawai.filter', 'diberhentikan')}}"><i class="btn-icon-prepend icon-sm mx-2" data-feather="user-x"></i><span class=""> Diberhentikan</span></a>
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i class="btn-icon-prepend icon-sm mx-2" data-feather="download"></i> <span class=""> Undah Data</span></a>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th>Nama</th>
                                        <th class="text-center">Kontak Pribadi</th>
                                        <th class="text-center">Jabatan Unit</th>
                                        <th class="text-center">Jabatan Pegawai</th>
                                        <th class="text-center">Status Pegawai</th>
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
                                                <a href="{{url('kepegawaian/data_pegawai/show/'.$pegawai->id)}}">
                                                    {{($pegawai->gelar_depan!=null)? $pegawai->gelar_depan.". ":""}}{{$pegawai->nama}}{{($pegawai->gelar_belakang!=null)?", ".$pegawai->gelar_belakang:""}}
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
                                                <strong>
                                                    @if($pegawai->unit_jabatan_aktif)
                                                        {{ $pegawai->unit_jabatan_aktif->nama_unit }}
                                                    @endif
                                                </strong><br>
                                                @if($pegawai->unit_jabatan_aktif)
                                                    {{ $pegawai->unit_jabatan_aktif->nama_jabatan_unit }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                
                                                @if($pegawai->jabatan_aktif)
                                                    {{ $pegawai->jabatan_aktif->nama_jabatan }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                    $status = "";
                                                    $color = "";
                                                    if($pegawai->status_pegawai == 0){
                                                        $color = "success";
                                                        $status = "AKTIF";
                                                    }elseif ($pegawai->status_pegawai == 1) {
                                                        $color = "danger";
                                                        $status = "TIDAK AKTIF";
                                                    }elseif ($pegawai->status_pegawai == 2) {
                                                        $color = "info";
                                                        $status = "MUTASI";
                                                    }elseif ($pegawai->status_pegawai == 3) {
                                                        $color = "primary";
                                                        $status = "PENSIUN";
                                                    }elseif ($pegawai->status_pegawai == 4) {
                                                        $color = "danger";
                                                        $status = "DIBERHENTIKAN";
                                                    }
                                                ?>
                                                <span class="badge rounded-pill border border-{{$color}} text-{{$color}}">{{$pegawai->status_kepegawaian}}: {{$status}}</span>

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
                            <small>Menampilkan {{$pegawais->count()}} data dari total {{$pegawai_count}} Pegawai.</small>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>

<div class="modal fade" id="createPegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Pegawai Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('data_pegawai.store')}}" method="post">
                @csrf
                <div class="modal-body p-5">
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-5 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status Kepegawaian Anda saat ini</label>
                                    <select name="status_kepegawaian" class="form-control" id="">
                                        <option value="">- Pilih Status Kepegawaian -</option>
                                        <option value="PNS">PNS</option>
                                        <option value="PPPK">PPPK</option>
                                        <option value="BLUD">Tenaga BLUD</option>
                                        <option value="KONTRAK">Tenaga Kontrak</option>
                                        <option value="MITRA">Tenaga Mitra</option>
                                        <option value="LAINNYA">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIP/NIPPPK/NRPK/NRPBLUD</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nip_nipppk_nrpk_nrpblud" placeholder="Nomor Induk Pegawai RSUD Brebes">
                                    @error('nip_nipppk_nrpk_nrpblud')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap dan Gelar</label>
                            <div class="row">
                                <div class="col-md-3 col-sm-12 mb-1">
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="gelar_depan" placeholder="Gelar Depan">
                                </div>
                                <div class="col-md-6 col-sm-12 mb-1">
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" placeholder="Nama Lengkap">
                                </div>
                                <div class="col-md-3 col-sm-12 mb-1">
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="gelar_belakang" placeholder="Gelar Belakang">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIP Lama</label> <sub><code><small>Khusus PNS</small></code></sub>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nip_lama" placeholder="NIP Lama">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIP Baru/NIP/NIPPPK</label> <sub><code><small>Khusus PNS/PPPK</small></code></sub>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nip_baru" placeholder="NIP Baru">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIK</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nik" placeholder="Nomor Identitas Kependudukan">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. KK</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="no_kk" placeholder="Nomor Kartu Keluarga">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. STR</label> <sub><code><small>Khusus Tenaga Kesehatan</small></code></sub>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="no_str" placeholder="Nomor Surat Tanda Registrasi">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NPWP</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="npwp" placeholder="Nomor Pokok Wajib Pajak">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Agama</label>
                                    <select name="agama" class="form-control" id="">
                                        <option value="">- Pilih Agama -</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                        <option value="Kristen Katolik">Kristen Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" id="">
                                        <option value="">- Pilih Jenis Kelamin -</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Golongan Darah</label>
                                    <select name="gol_darah" class="form-control" id="">
                                        <option value="">- Pilih Gol. Darah -</option>
                                        <option value="A">A</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="AB">AB</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="B">B</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="O">O</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                        <option value="Tidak Tahu">Tidak Tahu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tempat_lahir" placeholder="Tempat Lahir">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_lahir" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. BPJS / KIS</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="no_bpjs_kis" placeholder="Nomor BPJS / KIS">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kelas BPJS</label>
                                    <select name="kelas_bpjs" class="form-control" id="">
                                        <option value="">- Pilih Kelas BPJS -</option>
                                        <option value="1">Kelas 1</option>
                                        <option value="2">Kelas 2</option>
                                        <option value="3">Kelas 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Pernikahan</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="MENIKAH" name="status_kawin" id="gender1">
                                    <label class="form-check-label" for="gender1">
                                    Menikah
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="BELUM MENIKAH" name="status_kawin" id="gender2">
                                    <label class="form-check-label" for="gender2">
                                    Belum Menikah
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="CERAI HIDUP" name="status_kawin" id="gender3">
                                    <label class="form-check-label" for="gender3">
                                    Cerai Hidup
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="CERAI MATI" name="status_kawin" id="gender3">
                                    <label class="form-check-label" for="gender3">
                                    Cerai Mati
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">RT</label>
                                    <input type="text" class="form-control" name="rt" placeholder="RT">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">RW</label>
                                    <input type="text" class="form-control" name="rw" placeholder="RW">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kelurahan / Desa</label>
                                    <input type="text" class="form-control" name="kelurahan_desa" placeholder="Nama Kelurahan atau Desa">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control" name="kecamatan" placeholder="Nama Kecamatan">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kota / Kabupaten</label>
                                    <input type="text" class="form-control" name="kota" placeholder="Nama Kota atau Kabupaten">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kode Pos</label>
                                    <input type="number" class="form-control" name="kode_pos" placeholder="Kode Pos">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Telp</label>
                                    <input type="text" class="form-control" name="telp" placeholder="No. Telpon Rumah">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. HP</label>
                                    <input type="text" class="form-control" name="no_hp" placeholder="No. HP (WhatsApp)">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kewarganegaraan</label>
                                    <input type="text" class="form-control" name="kebangsaan" placeholder="WNI">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Angka Kredit</label>
                                    <input type="text" class="form-control bc-success" name="angka_kredit" data-inputmask="'alias': 'currency'" placeholder="Nilai Angka Kredit">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Taspen</label>
                                    <select name="taspen" class="form-control" id="">
                                        <option value="">- Pilih Status Taspen -</option>
                                        <option value="0">Sudah</option>
                                        <option value="1">Belum</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tunjangan</label>
                                    <input type="number" class="form-control" name="tunjangan">
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