@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item" aria-current="page">Pegawai</li>
        <li class="breadcrumb-item active" aria-current="page">Detail Data Pegawai</li>
    </ol>
</nav>
<h4 class="page-title mb-4">{{($pegawai->gelar_depan!=null)? $pegawai->gelar_depan.". ":""}}{{$pegawai->nama}}{{($pegawai->gelar_belakang!=null)?", ".$pegawai->gelar_belakang:""}} <small class="text-muted">{{$pegawai->nip_nipppk_nrpk_nrpblud}}</small></h4> 
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-9 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0">Biodata Diri Pegawai<h6>  
                                    <div class="d-flex">
                                        @if ($pegawai->status_pegawai != 1)
                                        <div class="pull-right pt-3">
                                            <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editPegawai">Perbaiki Data Pegawai</a>
                                        </div> 
                                        @endif
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                @if ($pegawai->foto == null)
                                <img src="{{ asset('assets/images/user-icon.png') }}" class="wd-100 wd-sm-200 me-3 mb-1" alt="...">
                                @else
                                <img src="{{ asset('storage/foto_pegawai/'.$pegawai->nip_nipppk_nrpk_nrpblud.'/'.$pegawai->foto) }}" class="wd-100 wd-sm-200 me-3 mb-1" alt="...">
                                @endif
                                <button class="btn btn-xs btn-secondary mt-1" data-bs-toggle="modal" data-bs-target="#gantiFoto">Ganti Foto</button>
                            </div>
                            <div class="col-sm-12 col-lg-9">
                                <div class="row">
                                    <div class="col-md-5 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Status Kepegawaian Anda saat ini</label>
                                            <select name="agama" class="form-control" disabled id="">
                                                <option value="{{$pegawai->status_kepegawaian}}">{{$pegawai->status_kepegawaian}}</option>
                                                <option value="0">PNS</option>
                                                <option value="1">PPPK</option>
                                                <option value="2">Tenaga BLUD</option>
                                                <option value="3">Tenaga Kontrak</option>
                                                <option value="4">Tenaga Mitra</option>
                                                <option value="5">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">
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
                                            </label>
                                            <input type="text" class="form-control" disabled id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$pegawai->nip_nipppk_nrpk_nrpblud}}" placeholder="Nomor Induk Pegawai RSUD Brebes">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama Lengkap dan Gelar</label>
                                    <input type="text" class="form-control" value="{{($pegawai->gelar_depan!=null)? $pegawai->gelar_depan.". ":""}}{{$pegawai->nama}}{{($pegawai->gelar_belakang!=null)?", ".$pegawai->gelar_belakang:""}}" disabled>
                                </div>
                                @if ($pegawai->status_kepegawaian == 'PNS' || $pegawai->status_kepegawaian == 'PPPK')
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIP Lama</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->nip_lama}}" autocomplete="off" name="nip_lama" placeholder="NIP Lama" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIP Baru</label> 
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->nip_baru}}" autocomplete="off" name="nip_baru" placeholder="NIP Baru" disabled>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">TMT RSUD</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{isset($pegawai->tmt_rsud) ? date('d-M-Y', strtotime($pegawai->tmt_rsud)) : '-'}}" autocomplete="off" name="nip_lama" placeholder="NIP Lama" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">MOTTO Pegawai</label>
                                    <textarea name="" class="form-control" id="" rows="3" disabled>{{$pegawai->motto}}</textarea>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIK</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->nik}}" autocomplete="off" name="nik" placeholder="Nomor Identitas Kependudukan" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. KK</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->no_kk}}" autocomplete="off" name="no_kk" placeholder="Nomor Kartu Keluarga" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. SIP / STP</label> <sub><code><small>Khusus Tenaga Kesehatan</small></code></sub>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->no_str}}" autocomplete="off" name="no_str" placeholder="Nomor Surat Tanda Registrasi" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NPWP</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->npwp}}" autocomplete="off" name="npwp" placeholder="Nomor Pokok Wajib Pajak" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Agama</label>
                                            <select name="agama" class="form-control" id="" disabled>
                                                <option value="{{$pegawai->agama}}">{{$pegawai->agama}}</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Kristen Protestan">Kristen Protestan</option>
                                                <option value="Kristen Katolik">Kristen Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Konghucu">Konghucu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jenis Kelamin</label>
                                            <input type="text" value="{{($pegawai->jenis_kelamin == 'L') ? 'Laki-Laki': 'Perempuan'}}" name="jenis_kelamin" class="form-control" id="" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Golongan Darah</label>
                                            <input type="text" class="form-control" value="{{($pegawai->gol_darah != null) ? $pegawai->gol_darah : 'Tidak Tahu'}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->tempat_lahir}}" autocomplete="off" name="tempat_lahir" placeholder="Tempat Lahir" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Lahir</label>
                                            <input type="text" name="tanggal_lahir" class="form-control" value="{{date('d-M-Y', strtotime($pegawai->tanggal_lahir));}}" id="" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. BPJS / KIS</label>
                                            <input type="text" class="form-control" value="{{$pegawai->no_bpjs_kis}}" id="exampleInputUsername1" autocomplete="off" name="no_bpjs_kis" placeholder="Nomor BPJS / KIS" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kelas BPJS</label>
                                            <input type="text" class="form-control" value="{{($pegawai->kelas_bpjs != null) ? 'Kelas '.$pegawai->kelas_bpjs : "Tidak Tahu"}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status Pernikahan</label>
                                    <input type="text" class="form-control" value="{{$pegawai->status_kawin}}" disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="" id="" class="form-control" rows="3" disabled>{{$pegawai->alamat}}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">RT</label>
                                            <input type="text" class="form-control" name="rt" value="{{$pegawai->rt}}" placeholder="RT" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">RW</label>
                                            <input type="text" class="form-control" name="rw" value="{{$pegawai->rw}}" placeholder="RW" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kelurahan / Desa</label>
                                            <input type="text" class="form-control" name="kelurahan_desa" value="{{$pegawai->kelurahan_desa}}" placeholder="Nama Kelurahan atau Desa" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" name="kecamatan" value="{{$pegawai->kecamatan}}" placeholder="Nama Kecamatan" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-8">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kota / Kabupaten</label>
                                            <input type="text" class="form-control" name="kota" value="{{$pegawai->kota}}" placeholder="Nama Kota atau Kabupaten" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kode Pos</label>
                                            <input type="text" class="form-control" name="kode_pos" value="{{$pegawai->kode_pos}}" placeholder="Kode Pos" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Telp</label>
                                            <input type="text" class="form-control" name="telp" value="{{$pegawai->telp}}" placeholder="No. Telpon Rumah" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. HP</label>
                                            <input type="text" class="form-control" name="no_hp" value="{{$pegawai->no_hp}}" placeholder="No. HP (WhatsApp)" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{$pegawai->email}}" placeholder="Email" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kewarganegaraan</label>
                                            <input type="text" class="form-control" name="kebangsaan" value="{{$pegawai->kebangsaan}}" placeholder="WNI" disabled>
                                        </div>
                                    </div>

                                    @if ($pegawai->status_kepegawaian == 'PNS' || $pegawai->status_kepegawaian == 'PPPK')
                                    <div class="col-md-3 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Angka Kredit</label>
                                            <input type="text" class="form-control bc-success" value="{{$pegawai->angka_kredit}}" name="angka_kredit" data-inputmask="'alias': 'currency'" placeholder="Nilai Angka Kredit" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Taspen</label>
                                            <input type="text" name="taspen" class="form-control" value="{{($pegawai->taspen == 0) ? 'Sudah' : 'Belum'}}" id="">
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-3 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tunjangan</label>
                                            <input type="text" class="form-control" value="{{"Rp " . number_format($pegawai->tunjangan, 2, ",", ".")}}" name="tunjangan" disabled>
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

    <div class="col-sm-12 col-md-3 grid-margin">
        @include('kepegawaian.datapegawai.sidebar_pegawai')
    </div>
    <!-- middle wrapper end -->
</div>

<div class="modal fade" id="gantiFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('data_pegawai.ganti_foto', $pegawai->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto</label>
                        <input type="file" name="foto" class="form-control" id="myDropify">
                    </div>
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editPegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('data_pegawai.update', $pegawai->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body p-5">
                    <div class="alert alert-danger" role="alert">
                        <h5><i data-feather="alert-circle"></i> Pemberitahuan</h5>
                        <p class="mt-2">Apabila Anda tidak mengetahui data yang harus diisi, mohon untuk tidak mengisi nilai seperti angka (0) atau (-). Cukup kosongkan data dan Simpan.</p>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-5 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Status Kepegawaian Anda saat ini</label>
                                    <select name="status_kepegawaian" class="form-control" id="">
                                        <option value="{{$pegawai->status_kepegawaian}}">- Ganti Status Kepegawaian -</option>
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
                                    <label for="" class="form-label">

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
                                    </label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->nip_nipppk_nrpk_nrpblud}}" name="nip_nipppk_nrpk_nrpblud" placeholder="Nomor Induk Pegawai RSUD Brebes">
                                    @error('nip_nipppk_nrpk_nrpblud')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Nama Lengkap dan Gelar</label>
                            <div class="row">
                                <div class="col-3">
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->gelar_depan}}" name="gelar_depan" placeholder="Gelar Depan">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->nama}}" name="nama" placeholder="Nama Lengkap">
                                </div>
                                <div class="col-3">
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->gelar_belakang}}" name="gelar_belakang" placeholder="Gelar Belakang">
                                </div>
                            </div>
                        </div>
                        @if ($pegawai->status_kepegawaian == 'PNS' || $pegawai->status_kepegawaian == 'PPPK')
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIP Lama</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->nip_lama}}" name="nip_lama" placeholder="NIP Lama">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIP Baru</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->nip_baru}}" name="nip_baru" placeholder="NIP Baru">
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TMT RSUD</label> <code><small>Tanggal mulai bekerja di RSUD Brebes</small></code>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tmt_rsud" value="{{$pegawai->tmt_rsud}}" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">MOTTO Pegawai</label>
                            <textarea name="motto" class="form-control" id="" rows="3">{{$pegawai->motto}}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">NIK</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->nik}}" name="nik" placeholder="Nomor Identitas Kependudukan">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. KK</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->no_kk}}" name="no_kk" placeholder="Nomor Kartu Keluarga">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. SIP / STR</label> <sub><code><small>Khusus Tenaga Kesehatan</small></code></sub>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->no_str}}"  name="no_str" placeholder="Nomor Surat Ijin Praktik (Dokter) Surat Tanda Registrasi (Perawat)">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">NPWP</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" value="{{$pegawai->npwp}}" autocomplete="off" name="npwp" placeholder="Nomor Pokok Wajib Pajak">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Agama</label>
                                    <select name="agama" class="form-control" id="">
                                        <option value="{{$pegawai->agama}}">{{$pegawai->agama}}</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                        <option value="Kristen Katolik">Kristen Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" id="">
                                        <option value="{{$pegawai->jenis_kelamin}}">- Ganti Jenis Kelamin -</option>
                                        <option value="L">Laki-Laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Golongan Darah</label>
                                    <select name="gol_darah" class="form-control" id="">
                                        <option value="{{$pegawai->gol_darah}}">- Ganti Gol. Darah -</option>
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
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" value="{{$pegawai->tempat_lahir}}" name="tempat_lahir" placeholder="Tempat Lahir">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group flatpickr" id="flatpickr-date">
                                        <input type="text" class="form-control" name="tanggal_lahir" value="{{$pegawai->tanggal_lahir}}" data-input>
                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. BPJS / KIS</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1" value="{{$pegawai->no_bpjs_kis}}" autocomplete="off" name="no_bpjs_kis" placeholder="Nomor BPJS / KIS">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kelas BPJS</label>
                                    <select name="kelas_bpjs" class="form-control" id="">
                                        <option value="{{$pegawai->kelas_bpjs}}">- Ganti Kelas BPJS -</option>
                                        <option value="1">Kelas 1</option>
                                        <option value="2">Kelas 2</option>
                                        <option value="3">Kelas 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Pernikahan</label>
                            <?php
                                $status_pernikahan = "";
                                if($pegawai->status_kawin=='MENIKAH'){
                                    $status_pernikahan = "MENIKAH";
                                }elseif($pegawai->status_kawin=='BELUM MENIKAH'){
                                    $status_pernikahan = "BELUM MENIKAH";
                                }elseif($pegawai->status_kawin=='CERAI HIDUP'){
                                    $status_pernikahan = "CERAI HIDUP";
                                }elseif($pegawai->status_kawin=='CERAI MATI'){
                                    $status_pernikahan = "CERAI MATI";
                                }

                            ?>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="MENIKAH" name="status_kawin" {{$status_pernikahan == "MENIKAH" ? "checked" : ""}}>
                                    <label class="form-check-label" for="gender1">
                                        Menikah
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="BELUM MENIKAH" name="status_kawin" {{$status_pernikahan == "BELUM MENIKAH" ? "checked" : ""}}>
                                    <label class="form-check-label" for="gender2">
                                        Belum Menikah
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="CERAI HIDUP" name="status_kawin" {{$status_pernikahan == "CERAI HIDUP" ? "checked" : ""}}>
                                    <label class="form-check-label" for="gender3">
                                        Cerai Hidup
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="CERAI MATI" name="status_kawin" {{$status_pernikahan == "CERAI MATI" ? "checked" : ""}}>
                                    <label class="form-check-label" for="gender3">
                                        Cerai Mati
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" id="" class="form-control" rows="3">{{$pegawai->alamat}}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">RT</label>
                                    <input type="text" class="form-control" value="{{$pegawai->rt}}" name="rt" placeholder="RT">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">RW</label>
                                    <input type="text" class="form-control" value="{{$pegawai->rw}}" name="rw" placeholder="RW">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kelurahan / Desa</label>
                                    <input type="text" class="form-control" value="{{$pegawai->kelurahan_desa}}" name="kelurahan_desa" placeholder="Nama Kelurahan atau Desa">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control" value = "{{$pegawai->kecamatan}}" name="kecamatan" placeholder="Nama Kecamatan">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kota / Kabupaten</label>
                                    <input type="text" class="form-control" value="{{$pegawai->kota}}" name="kota" placeholder="Nama Kota atau Kabupaten">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kode Pos</label>
                                    <input type="number" class="form-control" value="{{$pegawai->kode_pos}}" name="kode_pos" placeholder="Kode Pos">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Telp</label>
                                    <input type="text" class="form-control" value="{{$pegawai->telp}}" name="telp" placeholder="No. Telpon Rumah">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">No. HP</label>
                                    <input type="text" class="form-control" value="{{$pegawai->no_hp}}" name="no_hp" placeholder="No. HP (WhatsApp)">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{$pegawai->email}}" name="email" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Kewarganegaraan</label>
                                    <input type="text" class="form-control" value="{{$pegawai->kebangsaan}}" name="kebangsaan" placeholder="WNI">
                                </div>
                            </div>
                            @if ($pegawai->status_kepegawaian == 'PNS' || $pegawai->status_kepegawaian == 'PPPK')
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Angka Kredit</label>
                                    <input type="text" class="form-control bc-success" value="{{$pegawai->angka_kredit}}" name="angka_kredit" data-inputmask="'alias': 'currency'" placeholder="Nilai Angka Kredit">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Taspen</label>
                                    <select name="taspen" class="form-control" id="">
                                        <option value="{{$pegawai->taspen}}">- Pilih Status Taspen -</option>
                                        <option value="0">Sudah</option>
                                        <option value="1">Belum</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Tunjangan</label>
                                    <input type="number" class="form-control" value="{{$pegawai->tunjangan}}" name="tunjangan">
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
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>


@endpush