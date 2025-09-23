@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item" aria-current="page">Pegawai</li>
        <li class="breadcrumb-item active" aria-current="page">Detail Data Pegawai</li>
    </ol>
</nav>
<h4 class="page-title mb-2">{{$pegawai->nama}} <small class="text-muted">{{$pegawai->nip_nipppk_nrpk_nrpblud}}</small></h4> 
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-3 grid-margin">
        <div class="col-12 mb-4">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">Biodata Diri</a>
                <a href="#" class="list-group-item list-group-item-action">Riwayat Jabatan Pegawai</a>
                <a href="#" class="list-group-item list-group-item-action">Riwayat Jabatan Unit</a>
                @if ($pegawai->status_kepegawaian == 'PNS')
                <a href="#" class="list-group-item list-group-item-action">Riwayat Golongan</a>
                @endif
                <a href="#" class="list-group-item list-group-item-action">Riwayat Pendidikan</a>
                <a href="#" class="list-group-item list-group-item-action">Berkas Pegawai</a>
                <a href="#" class="list-group-item list-group-item-action">Data Suami/Istri</a>
                <a href="#" class="list-group-item list-group-item-action">Data Anak</a>
            </div>
        </div>
          <div class="col-12">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Masa Kerja Berkala
                  <span class="badge bg-primary rounded-pill">8 tahun 7 bulan</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Masa Kerja di RSUD Brebes
                  <span class="badge bg-primary rounded-pill">4 tahun 9 bulan</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Usia
                  <span class="badge bg-primary rounded-pill">45 Tahun</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  Perkiraan Pensiun
                  <span class="badge bg-primary rounded-pill">2035</span>
                </li>
              </ul>
          </div>
    </div>
    <div class="col-sm-12 col-md-9 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0">Daftar Jabatan Unit RSUD Brebes</h6>     
                                </div>
                            </div>
                            {{-- <div class="pull-right">
                                <button class="btn btn-success">Simpan Perubahan Terbaru</button>
                            </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <img src="{{ asset('assets/images/user-icon.png') }}" class="wd-100 wd-sm-200 me-3" alt="...">
                                <button class="btn btn-xs btn-success">Ganti Foto</button>
                            </div>
                            <div class="col-sm-12 col-lg-9">
                                <div class="row">
                                    <div class="col-5">
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
                                    <div class="col-7">
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
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$pegawai->gelar_depan}}" placeholder="Gelar Depan" disabled>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$pegawai->nama}}" placeholder="Nama Lengkap" disabled>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$pegawai->gelar_belakang}}" placeholder="Gelar Belakang" disabled>
                                        </div>
                                    </div>
                                    @error('nama')
                                        <code>{{$message}}</code>
                                    @enderror
                                </div>
                                @if ($pegawai->status_kepegawaian == 'PNS' || $pegawai->status_kepegawaian == 'PPPK')
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIP Lama</label> <sub><code><small>Khusus PNS</small></code></sub>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->nip_lama}}" autocomplete="off" name="nip_lama" placeholder="NIP Lama" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIP Baru</label> <sub><code><small>Khusus PNS</small></code></sub>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->nip_baru}}" autocomplete="off" name="nip_baru" placeholder="NIP Baru" disabled>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIK</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->nik}}" autocomplete="off" name="nik" placeholder="Nomor Identitas Kependudukan" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. KK</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->no_kk}}" autocomplete="off" name="no_kk" placeholder="Nomor Kartu Keluarga" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. STR</label> <sub><code><small>Khusus Tenaga Kesehatan</small></code></sub>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->no_str}}" autocomplete="off" name="no_str" placeholder="Nomor Surat Tanda Registrasi" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NPWP</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->npwp}}" autocomplete="off" name="npwp" placeholder="Nomor Pokok Wajib Pajak" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
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
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jenis Kelamin</label>
                                            <select name="jenis_kelamin" class="form-control" id="" disabled>
                                                <option value="{{$pegawai->jenis_kelamin}}">{{($pegawai->jenis_kelamin == 'L') ? 'Laki-Laki': 'Perempuan'}}</option>
                                                <option value="L">Laki-Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Golongan Darah</label>
                                            <select name="gol_darah" class="form-control" id="" disabled>
                                                <option value="{{$pegawai->gol_darah}}">{{$pegawai->gol_darah}}</option>
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
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$pegawai->tempat_lahir}}" autocomplete="off" name="tempat_lahir" placeholder="Tempat Lahir" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggal Lahir</label>
                                            <input type="text" class="form-control" name="tanggal_lahir" value="{{$pegawai->tanggal_lahir}}" data-input disabled>
                                            <div class="input-group flatpickr" id="flatpickr-date">
                                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                            </div>
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
                                            <select name="kelas_bpjs" class="form-control" id="" disabled>
                                                <option value="{{$pegawai->kelas_bpjs}}">{{($pegawai->kelas_bpjs != null) ? 'Kelas '.$pegawai->kelas_bpjs : "Tidak Tahu"}}</option>
                                                <option value="1">Kelas 1</option>
                                                <option value="2">Kelas 2</option>
                                                <option value="3">Kelas 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status Pernikahan</label>
                                    <input type="text" class="form-control" value="{{$pegawai->status_kawin}}" disabled>
                                    <?php
                                        $status_pernikahan = "";
                                        if($pegawai->status_kawin=='MENIKAH'){
                                            $status_pernikahan = "0";
                                        }elseif($pegawai->status_kawin=='BELUM MENIKAH'){
                                            $status_pernikahan = "1";
                                        }elseif($pegawai->status_kawin=='CERAI HIDUP'){
                                            $status_pernikahan = "2";
                                        }elseif($pegawai->status_kawin=='CERAI MATI'){
                                            $status_pernikahan = "3";
                                        }

                                    ?>
                                    {{-- <div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" value="0" name="status_kawin" {{$status_pernikahan == "0" ? "checked" : ""}} disabled>
                                            <label class="form-check-label" for="gender1">
                                                Menikah
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" value="1" name="status_kawin" {{$status_pernikahan == "1" ? "checked" : ""}} disabled>
                                            <label class="form-check-label" for="gender2">
                                                Belum Menikah
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" value="2" name="status_kawin" {{$status_pernikahan == "2" ? "checked" : ""}} disabled>
                                            <label class="form-check-label" for="gender3">
                                                Cerai Hidup
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" value="3" name="status_kawin" {{$status_pernikahan == "3" ? "checked" : ""}} disabled>
                                            <label class="form-check-label" for="gender3">
                                                Cerai Mati
                                            </label>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="" id="" class="form-control" rows="3" disabled></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">RT</label>
                                            <input type="text" class="form-control" name="rt" placeholder="RT" disabled>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">RW</label>
                                            <input type="text" class="form-control" name="rw" placeholder="RW" disabled>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kelurahan / Desa</label>
                                            <input type="text" class="form-control" name="kelurahan_desa" placeholder="Nama Kelurahan atau Desa" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control" name="kecamatan" placeholder="Nama Kecamatan" disabled>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kota / Kabupaten</label>
                                            <input type="text" class="form-control" name="kota_kabupaten" placeholder="Nama Kota atau Kabupaten" disabled>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kode Pos</label>
                                            <input type="text" class="form-control" name="kode_pos" placeholder="Kode Pos" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Telp</label>
                                            <input type="text" class="form-control" name="telp" placeholder="No. Telpon Rumah" disabled>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">No. HP</label>
                                            <input type="text" class="form-control" name="no_hp" placeholder="No. HP (WhatsApp)" disabled>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" placeholder="Email" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kewarganegaraan</label>
                                            <input type="text" class="form-control" name="kebangsaan" placeholder="WNI" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Angka Kredit</label>
                                            <input type="text" class="form-control bc-success" name="angka_kredit" data-inputmask="'alias': 'currency'" placeholder="Nilai Angka Kredit" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Taspen</label>
                                            <select name="taspen" class="form-control" id="" disabled>
                                                <option value="">- Pilih Status Taspen -</option>
                                                <option value="0">Sudah</option>
                                                <option value="1">Belum</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tunjangan</label>
                                            <input type="text" class="form-control" name="tunjangan" disabled>
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
    <!-- middle wrapper end -->
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
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