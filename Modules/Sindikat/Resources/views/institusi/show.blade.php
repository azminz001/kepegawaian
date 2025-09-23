@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item" aria-current="page">Institusi</li>
        <li class="breadcrumb-item active" aria-current="page">Profil</li>
    </ol>
</nav>
<h4 class="page-title mb-4">{{$institusi->nama}}</small></h4> 
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 col-md-3 grid-margin">
        @include('sindikat::institusi.sidebar')
    </div>
    <div class="col-sm-12 col-md-9 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex justify-content-between flex-column flex-md-row">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                    <h6 class="card-title mb-0"><i class="btn-icon-prepend mx-2 mdi mdi-office-building" ></i> Profil Data Institusi</h6>            
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0">
                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus Institusi {{$institusi->nama}}?');" action="{{ route('sindikat.institusi.destroy', $institusi->id) }}" method="POST">
                                    <a class="btn btn-xs btn-success btn-icon-text" data-bs-toggle="modal" data-bs-target="#editPegawai"><i class="btn-icon-prepend" data-feather="edit"></i> Ubah Data Institusi</a>
                                    @if (Auth::user()->level == 0 || Auth::user()->level == 4)
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger btn-icon-text"><i class="btn-icon-prepend" data-feather="trash-2"></i> Hapus Data Institusi</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                @if ($institusi->logo == null)
                                <img src="{{ asset('assets/images/user-icon.png') }}" class="wd-100 wd-sm-200 me-3 mb-1" alt="...">
                                @else
                                <img src="{{ asset('storage/sindikat/institusi/logo/'.$institusi->logo) }}" class="wd-100 wd-sm-200 me-3 mb-1" alt="...">
                                @endif
                                <button class="btn btn-xs btn-secondary mt-1" data-bs-toggle="modal" data-bs-target="#gantiLogo">Ganti Logo</button>
                            </div>
                            <div class="col-sm-12 col-lg-9">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Status Institusi </label>
                                            <input type="text" class="form-control" value="{{($institusi->status == 0) ? 'Tidak Aktif' : 'Aktif'}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tingkatan Institusi</label>
                                            @php
                                                $level = "";
                                                if ($institusi->level == 1) {
                                                    $level = "Perguruan Tinggi";
                                                }else if($institusi->level == 2){
                                                    $level = "SMK";
                                                }else{
                                                    $level = "Institusi Pendidikan Non Formal";
                                                }
                                            @endphp
                                            <input type="text" class="form-control" value="{{$level}}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Akreditasi</label>
                                            <input type="text" class="form-control" value="{{$institusi->akreditasi}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">
                                        Nama Institusi / Lembaga
                                    </label>
                                    <input type="text" class="form-control" disabled id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$institusi->nama}}">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">
                                        Nama Pimpinan
                                    </label>
                                    <input type="text" class="form-control" disabled id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$institusi->nama_pimpinan}}">
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="" id="" class="form-control" rows="3" disabled>{{$institusi->alamat}}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Kota</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$institusi->kota}}" autocomplete="off" name="no_kk" placeholder="Nomor Kartu Keluarga" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Provinsi</label>
                                            <input type="text" class="form-control" id="exampleInputUsername1" value="{{$institusi->provinsi}}" autocomplete="off" name="no_kk" placeholder="Nomor Kartu Keluarga" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Telp</label>
                                            <input type="text" class="form-control" name="telp" value="{{$institusi->telp}}" placeholder="No. Telpon Rumah" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{$institusi->email}}" placeholder="Email" disabled>
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

<div class="modal fade" id="gantiLogo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('sindikat.institusi.ganti_logo', $institusi->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Pilih Foto</label>
                        <input type="file" name="logo" class="form-control" id="myDropify">
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
            <form action="{{ route('sindikat.institusi.update', $institusi->id)}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body p-3">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Status Institusi </label>
                                        <select name="status" class="form-control" id="">
                                            <option value="{{$institusi->status}}">- Perbarui Status Institusi -</option>
                                            <option value="0">Tidak Aktif</option>
                                            <option value="1">Aktif</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Tingkat Lembaga/Institusi</label>
                                        <select name="level" class="form-control" id="" required>
                                            <option value="{{$institusi->level}}">- Perbarui Tingkatan Institusi-</option>
                                            <option value="1">Perguruan Tinggi</option>
                                            <option value="2">SMK</option>
                                            <option value="0">Institusi Pendidikan Non Formal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Akreditasi</label>
                                        <select name="akreditasi" class="form-control" id="">
                                            <option value="{{$institusi->akreditasi}}">- Perbarui Akreditasi Institusi -</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="-">Tidak memiliki Akreditasi</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">
                                    Nama Institusi / Lembaga
                                </label>
                                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" value="{{$institusi->nama}}">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">
                                    Nama Pimpinan
                                </label>
                                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama_pimpinan" value="{{$institusi->nama_pimpinan}}">
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" id="" class="form-control" rows="3">{{$institusi->alamat}}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Kota</label>
                                        <input type="text" class="form-control" id="exampleInputUsername1" value="{{$institusi->kota}}" autocomplete="off" name="kota" placeholder="Kota/Kabupaten">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Provinsi</label>
                                        <input type="text" class="form-control" id="exampleInputUsername1" value="{{$institusi->provinsi}}" autocomplete="off" name="provinsi" placeholder="Provinsi">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Telp</label>
                                        <input type="text" class="form-control" name="telp" value="{{$institusi->telp}}" placeholder="No. Telpon Rumah">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{$institusi->email}}" placeholder="Email">
                                    </div>
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
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
  @endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dropify.js') }}"></script>

@endpush