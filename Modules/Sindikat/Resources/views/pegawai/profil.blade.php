@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item active" aria-current="page">Instruktur</li>
        <li class="breadcrumb-item active" aria-current="page">Profil</li>
    </ol>
</nav>
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
                                    <h6 class="card-title mb-0">Detail Profil</h6>            
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <button class="btn btn-success btn-sm btn-icon-text" onclick="printDiv('printLetter');"><i class="btn-icon-prepend" data-feather="printer"></i>Cetak Biodata</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="printLetter">
                            <center><h5 class="mb-3">Profil Instruktur Klinik <small><i>(Clinical Instructure)</i></small> RSUD Brebes</h5></center>
                            <h6 class="card-title mb-2">Data Diri</h6>    
                            <table width="100%" class="mb-4">
                                <tr>
                                    <td width="80%">
                                        <table class="table table-bordered" border="1">
                                            <tbody>
                                                <tr>
                                                    <td width="10%" style="font-size: 0.85em;">Nama</td>
                                                    <td width="2%" style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">{{($pegawai->gelar_depan!=null)? $pegawai->gelar_depan.". ":""}}{{$pegawai->nama}}{{($pegawai->gelar_belakang!=null)?", ".$pegawai->gelar_belakang:""}}</td>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $jenis_induk = "";
                                                        if($pegawai->status_kepegawaian == 'PNS'){
                                                            $status_pegawai = "NIP";
                                                        }elseif ($pegawai->status_kepegawaian == 'PPPK') {
                                                            $status_pegawai = "NIPPPK";
                                                        }else {
                                                            $status_pegawai = "NRP";
                                                        }
                                                    @endphp
                                                    <td style="font-size: 0.85em;">{{$status_pegawai}}</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">{{$pegawai->nip_nipppk_nrpk_nrpblud}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.85em;">Tempat / Tanggal Lahir</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">{{$pegawai->tempat_lahir}} / {{date('d-M-Y', strtotime($pegawai->tanggal_lahir));}}</td>
                                                </tr>
                                                @if (!empty($pegawai->golongan_aktif))
                                                <tr>
                                                    <td style="font-size: 0.85em;">Pangkat / Golongan</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">{{($pegawai->status_kepegawaian == 'PNS') ? $pegawai->golongan_aktif->nama_pangkat_pns." / ".$pegawai->golongan_aktif->golongan_pns: $pegawai->golongan_aktif->golongan_pppk}}</td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td style="font-size: 0.85em;">Jabatan Unit</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">
                                                        <strong>{{$pegawai->unit_jabatan_aktif->nama_unit}}</strong><br />
                                                        {{$pegawai->unit_jabatan_aktif->nama_jabatan_unit}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.85em;">Jabatan Pegawai</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">
                                                        {{$pegawai->jabatan_aktif->nama_jabatan}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.85em;">Alamat</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">
                                                        {{$pegawai->alamat}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.85em;">No. HP</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">
                                                        {{$pegawai->no_hp}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.85em;">Email</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;">
                                                        {{$pegawai->email}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size: 0.85em;">Motto</td>
                                                    <td style="font-size: 0.85em;">:</td>
                                                    <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                        {{$pegawai->motto}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="20%" class="text-center" valign="top">
                                        @if ($pegawai->foto == null)
                                        <img src="{{ asset('assets/images/user-icon.png') }}" class="wd-100 wd-sm-200 me-3 mb-1" style="margin-left: 12px" alt="...">
                                        @else
                                        <img src="{{ asset('storage/foto_pegawai/'.$pegawai->nip_nipppk_nrpk_nrpblud.'/'.$pegawai->foto) }}" style="margin-left: 12px" class="wd-100 wd-sm-200 me-3 mb-1" width="200px" alt="...">
                                        @endif
                                    </td>
                                </tr>
                            </table>       
                            <h6 class="card-title mb-2">Riwayat Pendidikan</h6>            
                            <div class="table-responsive mb-4">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Jenjang</th>
                                            <th class="text-center">Nama Institusi Penidikan</th>
                                            <th class="text-center">Program Studi</th>
                                            <th class="text-center">Tahun Lulus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($pegawai->riwayat_pendidikan as $key => $riwayat_pendidikan)
                                        <tr>
                                            <td scope="row" class="text-center" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td class="text-center" style="font-size: 0.85em;">
                                                {{$riwayat_pendidikan->jenjang_pendidikan->nama}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_pendidikan->nama_sekolah_pt}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_pendidikan->jurusan}}
                                            </td>
                                            <td class="text-center" style="font-size: 0.85em;">
                                                {{date('Y', strtotime($riwayat_pendidikan->tanggal_lulus))}}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" style="font-size: 0.85em;"><small>Tidak ada data Riwayat Pendidikan Pegawai</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </div>
                            <h6 class="card-title mb-2">Riwayat Pelatihan / Diklat</h6>            
                            <div class="table-responsive mb-4">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="">No</th>
                                            <th class="">Nama Diklat</th>
                                            <th class="">Institusi Penyelenggara</th>
                                            <th class="text-center">Tanggal Pelaksanaan</th>
                                            <th class="">Durasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($pegawai->riwayat_diklat as $key => $riwayat_diklat)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                <span class="badge rounded-pill border border-success text-success">{{$riwayat_diklat->jenis_diklat}}</span><br>
                                                <p class="mt-1 mb-1"><strong>{{$riwayat_diklat->nama_diklat}}</strong></p>
                                            </td>
                                            <td style="font-size: 0.85em; word-wrap: break-word;white-space: normal;">
                                                <strong>{{$riwayat_diklat->institusi_penyelenggara}}</strong> <br>
                                                Tempat Diklat: <span class="badge rounded-pill border border-primary text-primary">{{$riwayat_diklat->tempat}}</span><br>
                                            </td>
                                            <td style="font-size: 0.85em; word-wrap: break-word;white-space: normal;">
                                                @if ($riwayat_diklat->tanggal_selesai != null)
                                                    {{date('d-M-Y', strtotime($riwayat_diklat->tanggal_mulai))}} s.d {{date('d-M-Y', strtotime($riwayat_diklat->tanggal_selesai))}}
                                                @else
                                                    {{date('d-M-Y', strtotime($riwayat_diklat->tanggal_mulai))}} 
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$riwayat_diklat->durasi}} JP
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" style="font-size: 0.85em;"><small>Tidak ada data Riwayat Diklat Pegawai</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <h6 class="card-title mb-2">Kegiatan Ilmiah</h6>            
                            <h6 class="mb-2">Riwayat Publikasi Artikel/Jurnal</h6>
                            <div class="table-responsive mb-2">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="" width="5%">No</th>
                                            <th class="">Judul Artikel/Jurnal</th>
                                            <th class="">Nama Jurnal</th>
                                            <th class="text-center">Volume</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pegawai->riwayat_artikel as $key => $artikel)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em; word-wrap: break-word;white-space: normal;">
                                                {{$artikel->judul_artikel}} <br />
                                                DOI:<br />
                                                <span class="badge rounded-pill border border-primary text-primary mt-2">{{($artikel->doi != null) ? $artikel->doi:""}}</span>
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$artikel->nama_jurnal}}<br/>
                                                Scope/Focus:<br />
                                                <span class="badge rounded-pill border border-success text-success mt-2">{{($artikel->scope != null) ? $artikel->scope:""}}</span>
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$artikel->volume}}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" style="font-size: 0.85em;"><small>Tidak memiliki data publikasi artikel atau jurnal.</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="mb-2 mt-4">Riwayat Penerbitan Buku</h6>
                            <div class="table-responsive mb-2">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="" width="5%">No</th>
                                            <th class="">Judul Buku</th>
                                            <th class="">Halaman</th>
                                            <th class="text-center">Penerbit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pegawai->riwayat_karya_buku as $key => $buku)
                                        <tr>
                                            <td scope="row">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$buku->judul}} <br />
                                                ISBN:<br />
                                                <span class="badge rounded-pill border border-primary text-primary mt-2">{{($buku->isbn != null) ? $buku->isbn:""}}</span>
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                {{$buku->halaman}}
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$buku->penerbit}}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" style="font-size: 0.85em;"><small>Tidak memiliki data penerbitan buku.</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="mb-2 mt-4">Riwayat Inovasi</h6>
                            <div class="table-responsive mb-4">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="" width="5%">No</th>
                                            <th class="">Judul Inovasi</th>
                                            <th class="">Tahun</th>
                                            <th class="text-center">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($pegawai->riwayat_inovasi as $key => $inovasi)
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
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" style="font-size: 0.85em;"><small>Tidak memiliki data inovasi</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <h6 class="card-title mb-2">Pengalaman Kerja</h6>            
                            <div class="table-responsive mb-4">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="">No</th>
                                            <th class="">Nama Perusahaan/Institusi</th>
                                            <th class="">Jabatan</th>
                                            <th class="text-center">Tahun</th>
                                            <th class="">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($pegawai->riwayat_pekerjaan as $key => $pekerjaan)
                                        <tr>
                                            <td scope="row">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                <strong>{{$pekerjaan->nama_instansi}}</strong><br>
                                                Kota/Kab. {{$pekerjaan->kota}}
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$pekerjaan->jabatan}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @if ($pekerjaan->tahun_selesai != null)
                                                    {{$pekerjaan->tahun_mulai}} - {{$pekerjaan->tahun_selesai}}
                                                @else
                                                    {{$pekerjaan->tahun_mulai}}
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$pekerjaan->keterangan}}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" style="font-size: 0.85em;"><small>Tidak ada data Riwayat Pekerjaan Pegawai</small></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <h6 class="card-title mb-2">Pengalaman Organisasi</h6>     
                            
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="">No</th>
                                            <th class="">Nama Organisasi</th>
                                            <th class="">Jabatan</th>
                                            <th class="text-center">Tahun</th>
                                            <th class="">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @forelse ($pegawai->riwayat_organisasi as $key => $organisasi)
                                        <tr>
                                            <td scope="row" style="font-size: 0.85em;">{{ $key + 1}}</td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                <strong>{{$organisasi->nama}}</strong>
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$organisasi->jabatan}}
                                            </td>
                                            <td style="font-size: 0.85em;">
                                                @if ($organisasi->tahun_selesai != null)
                                                    {{$organisasi->tahun_mulai}} - {{$organisasi->tahun_selesai}}
                                                @else
                                                    {{$organisasi->tahun_mulai}}
                                                @endif
                                            </td>
                                            <td style="font-size: 0.85em;word-wrap: break-word;white-space: normal;">
                                                {{$organisasi->keterangan}}
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" style="font-size: 0.85em;"><small>Tidak ada data Riwayat Organisasi Pegawai</small></td>
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


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>

@endpush


<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>