@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <style>
    .feather-46{
        width: 46px;
        height: 46px;
    }

    .feather-58{
        width: 58px;
        height: 58px;
    }
    .clock {
        font-weight:600;
        margin-top: 20px;
        font-size: 24px;
        font-family: 'Courier New', Courier, monospace;
        letter-spacing: 7px;
        font-weight: lighter;
        /* background-color: rgba(255, 255, 255, 0.5); */
        padding: 10px;
        border-radius: 12px;
    }
    .perfect-scrollbar-example {
        position: relative;
        max-height: 450px;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Dashboard SIM-RSUD Brebes</h4>
  </div>
  {{-- <div class="d-flex align-items-center flex-wrap text-nowrap">
    <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
      <i class="btn-icon-prepend" data-feather="printer"></i>
      Print
    </button>
    <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
      <i class="btn-icon-prepend" data-feather="download-cloud"></i>
      Download Report
    </button>
  </div> --}}
</div>

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
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
                                    <h5 class="text-success"><i data-feather="user-check" class="mx-2"></i> AKTIF</h5>
                                </div>
                                <div class="col-3">
                                    <h5 class="mb-2 text-success">: {{$pegawai_active}}</h5>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-9">
                                    <h5 class="text-danger"><i data-feather="user-x" class="mx-2"></i> TIDAK AKTIF</span></h5>
                                </div>
                                <div class="col-3">
                                    <h5 class="mb-2 text-danger">: {{$pegawai_inactive}}</h5>
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
                        <h6 class="card-title mb-0">Unit Kerja</h6>
                    </div>
                    <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-3">{{$unit}}</h3>
                        <div class="d-flex align-items-baseline">
                        <p class="text-primary">
                            <span>UNIT</span>
                        </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <p align="right"><i data-feather="server" class="feather-58 text-primary"></i></p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Jabatan Unit</h6>
                    </div>
                    <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-3">{{$jabatan_unit}}</h3>
                        <div class="d-flex align-items-baseline">
                        <p class="text-primary">
                            <span>Jabatan</span>
                        </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <table width="100%">
                            <tbody>
                                @foreach ($jenis_jabatan as $jenis)
                                <tr>
                                    <td>{{$jenis->nama}}</td>
                                    <td>:</td>
                                    <td>{{$jenis->jabatan_unit->count()}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h6 class="card-title mb-0">Jabatan Pegawai</h6>
                    </div>
                    <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2 mt-3">{{$jabatan_pegawai}}</h3>
                        <div class="d-flex align-items-baseline">
                        <p class="text-primary">
                            <span>Jabatan</span>
                        </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-12 col-xl-7">
                        <p align="right"><i data-feather="briefcase" class="feather-58 text-primary"></i></p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div> <!-- row -->
<div class="row">
    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Statisktik Kepegawaian RSUD</h6>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <label for="" class="text-primary">Jumlah Pegawai sudah mengisi Jabatan Pegawai</label>
                        <canvas id="kelJabatanChart"></canvas>
                    </div>
                    <div class="col-lg-4 col-sm-12 p-5">
                        <canvas id="genderDistributionChart"></canvas>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Welcome / Selamat Datang / Sugeng Rawuh</h6>
                </div>
                <div class="text-center mt-4 mb-2">
                    <img src="https://rsud.brebeskab.go.id/wp-content/uploads/2022/10/logo_rev.svg" height="60px" alt="" srcset="">
                </div>
                <div id="MyClockDisplay" class="clock text-center" onload="showTime()"></div>
                <h5 class="text-center">{{date('d - M - Y')}}</h5>
                <div class="row mb-3 text-center">
                    <h5 class="mt-4"><strong>SISTEM INFORMASI MANAJEMEN RSUD</strong></h5>
                    <P class="mb-4">KABUPATEN BREBES</P>
                    <div class="col-6 d-flex justify-content-end">
                        <div class="row">
                            <label class="d-flex align-items-center justify-content-end tx-10 text-uppercase fw-bolder">Email <span class="p-1 ms-2 rounded-circle bg-secondary"></span></label>
                            <p class="fw-bolder mb-0 text-end">rsudbbs@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label class="d-flex align-items-center tx-10 text-uppercase fw-bolder"><span class="p-1 me-2 rounded-circle bg-primary"></span> No. Telp</label>
                            <p class="fw-bolder mb-0 text-start">(0283) 671431</p>
                        </div>
                    </div>
                </div>
                <div class="d-grid mt-8">
                <a href="https://rsud.brebeskab.go.id" class="btn btn-primary" target="blank">Website Official RSUD </a>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

<div class="row">

    <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                    <h6 class="card-title mb-0">Selamat Ulang Tahun</h6>
                    {{-- <div class="pull-right">
                        <form action="{{ route('sendBirthdayMessages') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-xs">Ucapkan HBD</button>
                        </form>
                    </div> --}}
                </div>
                <div class="table-responsive perfect-scrollbar-example">
                    <label for="">Hari ini</label>
                    @forelse ($pegawai_birthday_now as $pegawai_now)
                    <a href="#" class="d-flex align-items-center border-bottom pb-3 mb-2 mt-2">
                        <div class="me-3">
                            @if ($pegawai_now->foto == null)
                                <img src="{{ asset('assets/images/user-icon.png') }}" class="rounded-circle" style="width: 35px;height:35px" alt="" srcset="">
                            @else
                                <img src="{{ asset('storage/foto_pegawai/'.$pegawai_now->nip_nipppk_nrpk_nrpblud.'/'.$pegawai_now->foto) }}" class="rounded-circle" style="width: 35px;height:35px;object-fit: cover" alt="...">
                            @endif
                        </div>
                        <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-normal text-body mb-1">{{$pegawai_now->nama}}</h6>
                        </div>
                        <p class="text-muted tx-13">{{$pegawai_now->nip_nipppk_nrpk_nrpblud}}</p>
                        </div>
                    </a>
                    @empty
                        <p class="mb-3 text-danger">Tidak ada pegawai yang ulang tahun hari ini</p>
                    @endforelse
                    @foreach ($anak_birthday_now as $anak)
                    <a href="#" class="d-flex align-items-center border-bottom pb-3 mb-2 mt-2">
                        <div class="me-3">
                            <img src="{{ asset('assets/images/user-icon.png') }}" class="rounded-circle" style="width: 35px;height:35px" alt="" srcset="">
                        </div>
                        <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-normal text-body mb-1">{{$anak->nama}}</h6>
                        </div>
                        <p class="text-muted tx-13">{{($anak->jenis_kelamin == 0 ) ? "Putra ":"Putri "}}dari {{($anak->pegawai->jenis_kelamin == 'L' ) ? "Bapak ":"Ibu "}} {{Str::title($anak->pegawai->nama)}}</p>
                        </div>
                    </a>
                    @endforeach 
                    <label for="mt-3 mb-2">7 Hari kedepan</label>
                    @forelse ($pegawai_birthday_sevendays as $pegawai_seven)
                    <a href="#" class="d-flex align-items-center border-bottom pb-3 mt-2">
                        <div class="me-3">
                            @if ($pegawai_seven->foto == null)
                                <img src="{{ asset('assets/images/user-icon.png') }}" class="rounded-circle" style="width: 35px;height:35px" alt="" srcset="">
                            @else
                                <img src="{{ asset('storage/foto_pegawai/'.$pegawai_seven->nip_nipppk_nrpk_nrpblud.'/'.$pegawai_seven->foto) }}" class="rounded-circle" style="width: 35px;height:35px;object-fit: cover" alt="...">
                            @endif
                        </div>
                        <div class="w-100">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-normal text-body mb-1">{{$pegawai_seven->nama}}</h6>
                            <p class="text-muted tx-12">{{date_format(date_create($pegawai_seven->tanggal_lahir), 'd M Y')}}</p>
                        </div>
                        <p class="text-muted tx-13">{{$pegawai_seven->nip_nipppk_nrpk_nrpblud}}</p>
                        </div>
                    </a>
                    @empty
                        <p>Tidak ada pegawai yang ulang tahun dalam 7 hari kedepan</p>
                    @endforelse
                </div>
            </div> 
        </div>
    </div>
    @if (Auth::user()->level == 0 || Auth::user()->level == 1)
    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Pegawai RSUD Usia > 55 Tahun</h6>
                </div>
                <div class="table-responsive perfect-scrollbar-example">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr style="background-color:">
                                <th class="pt-0">#</th>
                                <th class="pt-0">Nama</th>
                                <th class="pt-0">NIP/NIPPPK/NRP</th>
                                <th class="pt-0">Jabatan</th>
                                <th class="pt-0">Usia</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pegawai_over as $key => $pegawai_akanpensiun)
                            @php
                                $tanggal_1  = new DateTime($pegawai_akanpensiun->tanggal_lahir);
                                $tanggal_2 = new DateTime();
                                $usia  = $tanggal_1->diff($tanggal_2);
                            @endphp
                            <tr style="{{($usia->y > 57) ? 'background-color:lightblue' : ''}}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <a href="{{route('data_pegawai.show', $pegawai_akanpensiun->id)}}">
                                        {{($pegawai_akanpensiun->gelar_depan!=null)? $pegawai_akanpensiun->gelar_depan.". ":""}}{{$pegawai_akanpensiun->nama}}{{($pegawai_akanpensiun->gelar_belakang!=null)?", ".$pegawai_akanpensiun->gelar_belakang:""}} 
                                    </a>
                                </td>
                                <td>{{$pegawai_akanpensiun->nip_nipppk_nrpk_nrpblud}}</td>
                                <td>
                                    
                                    <span class="badge bg-{{isset($pegawai_akanpensiun->jabatan_aktif->nama_jabatan) ? 'success' : 'danger'}}">{{isset($pegawai_akanpensiun->jabatan_aktif->nama_jabatan) ? $pegawai_akanpensiun->jabatan_aktif->nama_jabatan : "Belum mengatur jabatan pegawai"}}</span>
                                </td>
                                {{-- <td>
                                    @forelse ($pegawai_akanpensiun->jabatan_aktif as $pegawai)
                                        <span class="badge bg-success">{{($pegawai->nama_jabatan)}}</span>
                                        
                                    @empty
                                        <span class="badge bg-success">Belum Atur Jabatan Pegawai</span>
                                    @endforelse
                                </td> --}}
                                <td>
                                    {{$usia->y." tahun ".$usia->m." bulan ".$usia->d." hari"}}
                                </td>
                            </tr>
                            @empty
                                <p>Tidak ada data pegawai </p>                        
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>
    @elseif (Auth::user()->level == 2)

    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Berita / Informasi Kepegawaian</h6>
                </div>
                <div class="table-responsive perfect-scrollbar-example">
                    @forelse ($beritas as $berita)
                    <a href="#" class="d-flex align-items-center border-bottom pb-3 mb-2 mt-2">
                        <div class="w-100 mx-2">
                            <div class="d-flex justify-content-between">
                                @php
                                    $color = "";
                                    $pesan = "";
                                    if ($berita->jenis == 0) {
                                        $color = "danger";
                                        $pesan = "Sangat Segera";
                                    }elseif ($berita->jenis == 1) {
                                        $color = "warning";
                                        $pesan = "Segera";
                                    }else{
                                        $color = "success";
                                        $pesan = "Biasa";
                                    }
                                @endphp
                                <h6 class="fw-normal text-body mb-0"><strong>{{$berita->perihal}}</strong></h6>
                                <span class="badge bg-{{$color}}">Jenis: {{$pesan}}</span>
                            </div>
                            <p class="tx-13 mt-2">{{$berita->deskripsi}}</p>
                        </div>
                    </a>
                    @empty
                        <p class="text-danger">Tidak ada Berita Terbaru</p>
                    @endforelse
                </div>
            </div> 
        </div>
    </div>
    @endif

</div> <!-- row -->
<div class="row">
    @if (Auth::user()->level == 0 || Auth::user()->level == 1 || $pegawai->status_kepegawaian == 'PNS')
    <div class="col-lg-4 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Status Kenaikan Gaji Berkala Tahun {{date('Y')}}</h6>
                </div>
                <div class="table-responsive perfect-scrollbar-example">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Nama</th>
                                <th class="pt-0">NIP</th>
                                <th class="pt-0">Tanggal Berlaku di {{date('Y')-2}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gaji_berkala_year_now as $key => $pegawai_now)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$pegawai_now->pegawai->nama}}</td>
                                    <td>{{$pegawai_now->pegawai->nip_nipppk_nrpk_nrpblud}}</td>
                                    <td class="text-center">{{date_format(date_create($pegawai_now->tanggal_mulai_berlaku), 'd-M-Y')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>   

    <div class="col-lg-3 col-xl-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Data Kenaikan Gaji Berkala Tahun {{date('Y') + 1}}</h6>
                </div>
                <div class="table-responsive perfect-scrollbar-example">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Nama</th>
                                <th class="pt-0">NIP</th>
                                <th class="pt-0">Tanggal Berlaku di {{date('Y')-1}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gaji_berkala_next_year as $key => $pegawai_depan)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$pegawai_depan->pegawai->nama}}</td>
                                    <td>{{$pegawai_depan->pegawai->nip_nipppk_nrpk_nrpblud}}</td>
                                    <td class="text-center">{{date_format(date_create($pegawai_depan->tanggal_mulai_berlaku), 'd-M-Y')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div>  
    @endif
    @if (Auth::user()->level == 0 || Auth::user()->level == 1)
    <div class="col-lg-5 col-xl-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Berita / Informasi Kepegawaian</h6>
                <div class="mb-2">
                    <a class="btn btn-xs btn-success" data-bs-toggle="modal" data-bs-target="#createBerita">Tambah Berita Baru</a>
                </div>
                </div>
                <div class="table-responsive perfect-scrollbar-example">
                    @forelse ($beritas as $berita)
                    <a href="#" class="d-flex align-items-center border-bottom pb-3 mb-2 mt-2">
                        <div class="me-3">
                            <form onsubmit="return confirm('Apakah Anda Yakin mengahapus berita ini?');" action="{{ route('berita.destroy', $berita->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs btn-icon">
                                    <i data-feather="trash-2"></i>
                                </button>
                            </form>
                        </div>
                        <div class="w-100 mx-2">
                            <div class="d-flex justify-content-between">
                                @php
                                    $color = "";
                                    $pesan = "";
                                    if ($berita->jenis == 0) {
                                        $color = "danger";
                                        $pesan = "Sangat Segera";
                                    }elseif ($berita->jenis == 1) {
                                        $color = "warning";
                                        $pesan = "Segera";
                                    }else{
                                        $color = "success";
                                        $pesan = "Biasa";
                                    }
                                @endphp
                                <h6 class="fw-normal text-body mb-0"><strong>{{$berita->perihal}}</strong></h6>
                                <span class="badge bg-{{$color}}">Jenis: {{$pesan}}</span>
                            </div>
                            <p class="tx-13 mt-2">{{$berita->deskripsi}}</p>
                        </div>
                    </a>
                    @empty
                        <p class="text-danger">Tidak ada Berita Terbaru</p>
                    @endforelse
                </div>
            </div> 
        </div>
    </div>  
    @endif
    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Data Pegawai dengan Permohonan Kontrak Kerja Tahun ini</h6>
                </div>
                <div class="table-responsive perfect-scrollbar-example">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Nama</th>
                                <th class="pt-0">NRP</th>
                                <th class="pt-0">Kepegawaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawaiDenganKontrakTahunIni as $key => $pegawai)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$pegawai->nama}}</td>
                                    <td>{{$pegawai->nip_nipppk_nrpk_nrpblud}}</td>
                                    <td class="text-center">{{$pegawai->status_kepegawaian}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div> 
    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline mb-2">
                <h6 class="card-title mb-0">Data Pegawai Belum ada Permohonan Kontrak Kerja Tahun ini</h6>
                </div>
                <div class="table-responsive perfect-scrollbar-example">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="pt-0">#</th>
                                <th class="pt-0">Nama</th>
                                <th class="pt-0">NRP</th>
                                <th class="pt-0">Kepegawaian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawaiBelumKontrakTahunIni as $key => $pegawai)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$pegawai->nama}}</td>
                                    <td>{{$pegawai->nip_nipppk_nrpk_nrpblud}}</td>
                                    <td class="text-center">{{$pegawai->status_kepegawaian}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </div> 
</div>
<div class="modal fade" id="createBerita" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Berita Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('berita.store')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="container">
                        <div class="mb-3">
                            <label for="" class="form-label">Jenis Berita*</label>
                            <select name="jenis" class="form-control" id="">
                                <option disabled selected value>- Pilih Jenis Berita -</option>
                                <option value="0">Sangat Segera</option>
                                <option value="1">Segera</option>
                                <option value="2">Biasa</option>
                            </select>
                            @error('jenis')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Perihal*</label>
                            <input type="text" name="perihal" class="form-control" placeholder="Berita, Pengumuman, Informasi, dll..." id="">
                            @error('perihal')
                                <code>{{$message}}</code>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Deskripsi*</label>
                            <textarea name="deskripsi" id="" class="form-control" cols="30" rows="7"></textarea>
                            @error('deskripsi')
                                <code>{{$message}}</code>
                            @enderror
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
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script>
        function showTime(){
        var date = new Date();
        var h = date.getHours(); // 0 - 23
        var m = date.getMinutes(); // 0 - 59
        var s = date.getSeconds(); // 0 - 59
        // var session = "AM";
        
        if(h == 0){
            h = 24;
        }
        
        // if(h > 12){
        //     h = h - 12;
        //     session = "PM";
        // }
        
        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;
        
        var time = h + ":" + m + ":" + s;
        document.getElementById("MyClockDisplay").innerText = time;
        document.getElementById("MyClockDisplay").textContent = time;
        
        setTimeout(showTime, 1000);
        
    }

    showTime();
  </script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    var ctx = document.getElementById('kelJabatanChart').getContext('2d');
    var kelJabatanChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($kel_jabatan), // Menggunakan label yang dikirim dari controller
            datasets: [{
                label: 'Pegawai RSUD',
                data: @json($jumlah_kel_jabatan), // Menggunakan data yang dikirim dari controller
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    var ctx = document.getElementById('genderDistributionChart').getContext('2d');
        var genderDistributionChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    `Laki-Laki: {{ $laki_laki }} Pegawai ({{ number_format($persentase_laki_laki, 2) }}%)`,
                    `Perempuan: {{ $perempuan }} Pegawai ({{ number_format($persentase_perempuan, 2) }}%)`
                ], // Label untuk jenis kelamin beserta jumlah dan persentase
                datasets: [{
                    data: [@json($laki_laki), @json($perempuan)], // Data jumlah dari controller
                    backgroundColor: ['#36A2EB', '#FF6384'], // Warna untuk masing-masing jenis kelamin
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    // tooltip: {
                    //     callbacks: {
                    //         label: function(tooltipItem) {
                    //             var total = @json($laki_laki) + @json($perempuan);
                    //             return `${tooltipItem.label}: ${tooltipItem.raw} Pegawai`;
                    //         }
                    //     }
                    // }
                }
            }
        });
    </script>
</script>
@endpush