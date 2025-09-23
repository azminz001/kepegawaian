@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">SINDIKAT</li>
        <li class="breadcrumb-item active" aria-current="page">Institusi / Lembaga</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Institusi / Lembaga Mitra Sindikat</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->
    <div class="col-sm-12 middle-wrapper">
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
                                <button class="btn btn-success btn-sm btn-icon-text" data-bs-toggle="modal" data-bs-target="#createInstitusi"><i class="mdi mdi-office-building"></i> Tambah Institusi Baru</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sindikat.institusi.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                    <i class="btn-icon-prepend" data-feather="search"></i>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Nama Institusi / Lembaga">
                                <button type="submit" class="btn btn-secondary btn-icon-text" style="margin-right: 14px">Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="10%"></th>
                                        <th>Nama</th>
                                        <th>Kontak</th>
                                        <th>Kota/Kabupaten</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($institusis as $key => $institusi)
                                        <tr>
                                            <td width="5%" scope="row">{{$key+1}}</td>
                                            <td>
                                                @if (!isset($institusi->logo))
                                                    <img src="{{ asset('assets/images/user-icon.png') }}" class="mx-2" style="width: 75px;height:75px" alt="" srcset="">
                                                @else
                                                    <div class="me-3">
                                                        <img src="{{ asset('storage/sindikat/institusi/logo/'.$institusi->logo) }}" class="mx-2" style="width: 75px;height:75px;object-fit: cover" alt="...">
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="word-wrap: break-word;white-space: normal;">
                                                <a href="{{url('sindikat/institusi/show/'.$institusi->id)}}">
                                                    {{$institusi->nama}}
                                                </a><br />
                                                @php
                                                    $jenis = "";
                                                    if ($institusi->level == '0') {
                                                        $jenis = "Non Formal";
                                                    }elseif ($institusi->level == '1') {
                                                        $jenis = "Perguruan Tinggi";
                                                    }elseif ($institusi->level == '2') {
                                                        $jenis = "SMK";
                                                    }else{
                                                        $jenis = "undefined";
                                                    }
                                                @endphp
                                                <span class="badge bg-success">Jenis Institusi: {{$jenis}}</span>
                                            </td>
                                            <td style="word-wrap: break-word;white-space: normal;">
                                                <table>
                                                    <tr>
                                                        <td>Nama Pimpinan</td>
                                                        <td>:</td>
                                                        <td><strong>{{$institusi->nama_pimpinan}}</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Telp</td>
                                                        <td>:</td>
                                                        <td>{{$institusi->telp}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>:</td>
                                                        <td>{{$institusi->email}}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>
                                                {{$institusi->kota}}
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill border border-{{$institusi->status == 0 ? 'danger':'success'}} text-{{$institusi->status == 0 ? 'danger':'success'}}">{{$institusi->status == 0 ? 'Tidak Aktif':'Aktif'}}</span>
                                            </td>
                                            <td>
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus arsip {{$institusi->nama}}?');" action="{{ route('sindikat.institusi.destroy', $institusi->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $institusis->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>
                            <small>Menampilkan {{$institusis->count()}} data dari total {{$institusi_count}} Institusi.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>

<div class="modal fade" id="createInstitusi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Tambah Institusi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body p-4">
                <form method="POST" action="{{ route('sindikat.institusi.store')}}">
                    @csrf
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Nama Lembaga</label>
                        <input type="text" class="form-control" name="nama" placeholder="Nama Lembaga / Institusi Pendidikan" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="">Tingkat Lembaga/Institusi</label>
                            <select name="level" class="form-control" id="" required>
                                <option disabled selected value>- Pilih Tingkatan -</option>
                                <option value="1">Perguruan Tinggi</option>
                                <option value="2">SMK</option>
                                <option value="0">Institusi Pendidikan Non Formal</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">Akreditasi</label>
                            <select name="akreditasi" class="form-control" id="" required>
                                <option disabled selected value>- Pilih Akreditasi -</option>
                                <option value="Unggul">Unggul</option>
                                <option value="Baik Sekali">Baik Sekali</option>
                                <option value="Baik">Baik</option>
                                <option value="Belum Terakreditasi">Belum Terakreditasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Nama Pimpinan Lembaga</label>
                        <input type="text" class="form-control" name="nama_pimpinan" placeholder="Nama Lengkap dan Gelar" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="">
                                <label for="userEmail" class="form-label">No. Telp</label>
                                <input type="telp" class="form-control" name="telp" placeholder="No. Telp. Institusi" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="">
                                <label for="userEmail" class="form-label">No. WhhatsApp</label>
                                <input type="telp" class="form-control" name="no_wa" placeholder="No. WhatsApp (Notifikasi)" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="">
                                <label for="userEmail" class="form-label">Email Institusi</label>
                                <input type="text" class="form-control" name="email" placeholder="Email Institusi" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Alamat Institusi" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <div class="">
                                <label for="userEmail" class="form-label">Kota</label>
                                <input type="telp" class="form-control" name="kota" placeholder="Kota" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="">
                                <label for="userEmail" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" name="provinsi" placeholder="Provinsi" required>
                                <input type="hidden" class="form-control" name="password" autocomplete="off" id="password" value="123456" required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>

@endpush