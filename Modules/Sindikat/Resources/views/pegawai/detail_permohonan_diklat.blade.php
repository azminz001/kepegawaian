@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item active" aria-current="page">Permohonan Diklat Pegawai</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Permohonan Diklat Pegawai</h3>
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
                                <h6 class="card-title mb-0">Detail Permohonan Diklat</h6>            
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 col-sm-12 p-3">
                                <iframe id="dokumen_embed" src="{{url('/storage/sindikat/permohonan_diklat/'.$diklat->upload)}}" type="application/pdf" width="100%" height="720px" style="display: none;"></iframe>
                                <img id="dokumen_image" src="{{url('/storage/sindikat/permohonan_diklat/'.$diklat->upload)}}" alt="Dokumen Gambar" style="display: none; max-width: 100%; height: auto;">
                            </div>
                            <div class="col-lg-7 col-sm-12">
                                <form action="{{route('sindikat.permohonan_diklat.update', $diklat->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <input type="hidden" name="pegawai_id" value="{{$diklat->pegawai_id}}">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Pemohon</label> 
                                                <input type="text" disabled class="form-control" autocomplete="off" name="nama_diklat" value="{{$diklat->pegawai->nama}}" placeholder="Nama, Tema, atau Judul Diklat">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nama Tema Pelatihan </label> 
                                                <input type="text" class="form-control" autocomplete="off" name="nama_diklat" value="{{$diklat->nama_diklat}}" placeholder="Nama, Tema, atau Judul Diklat">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Penyelenggara</label> 
                                                    <input type="text" class="form-control" value="{{$diklat->penyelenggara}}" autocomplete="off" name="penyelenggara"  placeholder="Penyelenggara Diklat">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Tempat</label>
                                                    <input type="text" class="form-control" value="{{$diklat->tempat}}" autocomplete="off" name="tempat" placeholder="Tempat Diklat">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Jenis Diklat</label>
                                                    <select name="jenis" class="form-control" id="jenis">
                                                        <option value="0" {{($diklat->jenis == 0 ? "selected":"")}}>Struktural</option>
                                                        <option value="1" {{($diklat->jenis == 1 ? "selected":"")}}>Fungsional</option>
                                                        <option value="2" {{($diklat->jenis == 2 ? "selected":"")}}>Teknis</option>
                                                        <option value="3" {{($diklat->jenis == 3 ? "selected":"")}}>Umum</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Model </label>
                                                    <select name="tipe" class="form-control" id="tipe">
                                                        <option value="0" {{($diklat->tipe == 0 ? "selected":"")}}>Luring (Offline)</option>
                                                        <option value="1" {{($diklat->tipe == 1 ? "selected":"")}}>Daring (Online)</option>
                                                        <option value="2" {{($diklat->tipe == 2 ? "selected":"")}}>Hybrid (Offline dan Online)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Tanggal Mulai</label>
                                                    <div class="input-group flatpickr" id="flatpickr-date">
                                                        <input type="text" class="form-control" name="tanggal_mulai" value="{{$diklat->tanggal_mulai}}" data-input>
                                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-3">
                                                    <label for="" class="form-label">Tanggal Selesai</label>
                                                    <div class="input-group flatpickr" id="flatpickr-date">
                                                        <input type="text" class="form-control" name="tanggal_selesai"  value="{{$diklat->tanggal_selesai}}" data-input>
                                                        <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <label for="" class="form-label">Link</label> 
                                                    <input type="text" class="form-control" value="{{$diklat->link}}" autocomplete="off" name="link" placeholder="Berikan Link Apabila ada Informasi Detail Diklat">
                                                </div>
                                                <div class="col-4">
                                                    <a href="{{$diklat->link}}" target="blank"><button class="btn btn-primary btn-sm" style="margin-top: 32px"> Buka Link</button></a>
                                                </div>
                                            </div>
                                        </div>
                                        @if (Auth::user()->level == '2')
                                        <div class="mb-3">
                                            <label for="" class="form-label">Perbarui Unggahan Informasi Diklat (Gambar/PDF)</label>
                                            <input type="file" class="form-control" name="upload">
                                        </div>                                        
                                        @elseif (Auth::user()->level == '4' || Auth::user()->level == '0')
                                        <div class="mb-3">
                                            <label for="" class="form-label">Status Permohonan: <span class="badge">{{$message ?? '-'}}</span></label>
                                            <select name="status" class="form-control" id="status">
                                                <option value="0" {{$diklat->status == 0 ? "selected":""}}>Diajukan</option>
                                                <option value="1" {{$diklat->status == 1 ? "selected":""}}>Dikonfirmasi</option>
                                                <option value="2" {{$diklat->status == 2 ? "selected":""}}>Dikoordinasikan</option>
                                                <option value="3" {{$diklat->status == 3 ? "selected":""}}>Dalam Proses</option>
                                                <option value="4" {{$diklat->status == 4 ? "selected":""}}>Disetujui</option>
                                                <option value="5" {{$diklat->status == 5 ? "selected":""}}>Ditolak</option>
                                            </select>
                                        </div>
                                        @endif
                                        <div class="mb-3">
                                            <label for="" class="form-label">Catatan Tambahan</label>
                                            <textarea name="catatan" cols="30" rows="5" class="form-control" placeholder="Berikan Catatan atau Informasi tambahan terkait Diklat">
                                                {{$diklat->catatan}}
                                            </textarea>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                        
                                    </div>
                                </form>
                                <div class="mb-3">
                                    <label for="">Daftar Peserta Diklat</label>
                                    <table class="table table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Jabatan / Unit Kerja</th>
                                                <th class="text-center">#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $key => $pesertaDiklat)
                                            <tr>
                                                <td class="text-center" style="font-size: 14px" scope="row">{{$key+1}}</td>
                                                <td style="font-size: 14px">{{$pesertaDiklat->pegawai->nama}}<br/><small class="text-default">{{$pesertaDiklat->pegawai->nip_nipppk_nrpk_nrpblud}}</small></td>
                                                <td style="font-size: 14px">{{$pesertaDiklat->pegawai->unit_jabatan_aktif->nama_jabatan_unit ?? 'Belum atur jabatan'}} / {{$pesertaDiklat->pegawai->unit_jabatan_aktif->nama_unit ?? 'Belum atur unit'}}</td>
                                                <td style="font-size: 12px" class="text-center">
                                                    <form onsubmit="return confirm('Apakah Anda Yakin mengahapus peserta a.n {{$pesertaDiklat->pegawai->nama}}?');" action="{{ route('sindikat.peserta_permohonan_diklat.destroy', $pesertaDiklat->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-xs btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
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
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>

  
  
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const fileName = "{{ $diklat->upload }}"; // Nama file dari backend
        const iframe = document.getElementById("dokumen_embed");
        const img = document.getElementById("dokumen_image");

        // Ekstrak ekstensi file
        const fileExtension = fileName.split('.').pop().toLowerCase();

        // Tampilkan elemen sesuai tipe file
        if (fileExtension === 'pdf') {
            iframe.style.display = 'block'; // Tampilkan iframe
            img.style.display = 'none';    // Sembunyikan img
        } else if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(fileExtension)) {
            iframe.style.display = 'none'; // Sembunyikan iframe
            img.style.display = 'block';  // Tampilkan img
        } else {
            alert('File tidak didukung.');
        }
    });
</script>
