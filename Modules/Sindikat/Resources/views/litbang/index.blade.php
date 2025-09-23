@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Sindikat</li>
        <li class="breadcrumb-item active" aria-current="page">Permohonan Penelitian dan Pengembangan</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Permohonan Litbang</h3>
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
                                <h6 class="card-title mb-0">Data</h6>            
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Pemohon</th>
                                        <th width="50%">Judul Penelitian</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data_permohonan_litbang as $key => $permohonan)
                                        <tr>
                                            <td width="5%" scope="row">{{$key+1}}</td>
                                            <td>
                                                <strong>{{$permohonan->pemohon->nama}}</strong>
                                                <p class="mt-2 mb-1">{{$permohonan->pemohon->perguruan_tinggi}}</p>
                                                <small class="text-muted">{{$permohonan->pemohon->no_hp}}</small>
                                            </td>
                                            <td style="word-wrap: break-word;white-space: normal;">
                                                {{$permohonan->judul_penelitian}} <br>
                                                <span class="badge bg-success mt-2">{{'Bidang Penelitian: '.$permohonan->bidang_penelitian}}</span>
                                            </td>
                                            <td style="word-wrap: break-word;white-space: normal;">
                                                {{date_format(date_create($permohonan->tanggal_mulai), 'd-M-Y')}} s.d {{date_format(date_create($permohonan->tanggal_selesai), 'd-M-Y')}}
                                            </td>
                                            <td>
                                                @php
                                                    $color = "";
                                                    $message = "";
                                                    if ($permohonan->status_permohonan == 0) {
                                                        $color = "primary";
                                                        $message = "Permohonan Diajukan";
                                                    }elseif ($permohonan->status_permohonan == 1) {
                                                        $color = "success";
                                                        $message = "Berkas Diterima";
                                                    }elseif ($permohonan->status_permohonan == 2) {
                                                        $color = "warning";
                                                        $message = "Permohonan Dikoordinasikan";
                                                    }elseif ($permohonan->status_permohonan == 3) {
                                                        $color = "primary";
                                                        $message = "Dalam Proses";
                                                    }elseif ($permohonan->status_permohonan == 4) {
                                                        $color = "success";
                                                        $message = "Permohonan Disetujui";
                                                    }elseif ($permohonan->status_permohonan == 5) {
                                                        $color = "danger";
                                                        $message = "Permohonan Ditolak";
                                                    }
                                                @endphp
                                                <span class="badge bg-{{$color}} mt-2">{{$message}}</span>
                                            </td>
                                            
                                            <td>
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus Penelitian: {{$permohonan->judul_penelitian}}?');" action="{{ route('sindikat.proposal_litbang.destroy', $permohonan->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{$permohonan->id}}" data-bs-toggle="modal" data-bs-target="#editRequestLitbang">
                                                        <i data-feather="edit"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-muted">
                                                Anda Belum Memiliki Permohonan Litbang
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $data_permohonan_litbang->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>
                            {{-- <small>Menampilkan {{$users->count()}} data dari total {{$user_count}} Pegawai.</small> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>

<div class="modal fade" id="editRequestLitbang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Detail Riwayat Jabatan Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editRequestLitbangForm" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 pr-4">
                                <div class="row">
                                    <h5 class="text-center mb-2">Identitas Pemohon</h5>
                                    <table class="table table-sm alert alert-primary mb-3">
                                        <tbody>
                                            <tr>
                                                <td scope="row">Nama</td>
                                                <td>:</td>
                                                <td><span id="nama_pemohon"></span></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">NIM</td>
                                                <td>:</td>
                                                <td><span id="nim"></span></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">Perguruan Tinggi</td>
                                                <td>:</td>
                                                <td><span id="perguruan_tinggi"></span></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">Fakultas</td>
                                                <td>:</td>
                                                <td><span id="fakultas"></span></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">Program Studi</td>
                                                <td>:</td>
                                                <td><span id="program_studi"></span></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">No. HP</td>
                                                <td>:</td>
                                                <td><span id="no_hp"></span></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">Email </td>
                                                <td>:</td>
                                                <td><span id="surel"></span></td>
                                            </tr>
                                            <tr>
                                                <td scope="row">Passcode </td>
                                                <td>:</td>
                                                <td><span id="passcode"></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h5>Berkas Pendukung</h5>
                                    <iframe id="dokumen_embed" type="application/pdf" width="100%" height="720px"></iframe>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 pl-4">
                                <h5 class="text-center mb-2">Informasi Permohonan Penelitian</h5>
                                <div class="row mb-3">
                                    <div class="col-md-9 col-sm-12">
                                        <label for="userEmail" class="form-label">Judul Penelitian</label>
                                        <input type="text" class="form-control" name="judul_penelitian" placeholder="" id="judul_penelitian">
                                    </div>
                                    <div class="col-md-3 col-sm-12">
                                        <label for="userEmail" class="form-label">Bidang</label>
                                        <select name="bidang_penelitian" class="form-control" id="bidang_penelitian">
                                            <option value="Medis">Medis</option>
                                            <option value="Farmasi">Farmasi</option>
                                            <option value="Keperawatan">Keperawatan</option>
                                            <option value="Administrasi">Administrasi</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="userEmail" class="form-label">Deskripsi Penelitian</label>
                                        <textarea name="deskripsi_penelitian" class="form-control" id="deskripsi_penelitian" cols="40" rows="7" placeholder="Deskripsi singkat rencana penelitian..."></textarea>
                                    </div>
                                </div>
                                <h5 class="mb-2">Tanggal Rencana Penelitian</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="userEmail" class="form-label">Tanggal Mulai</label>
                                        <div class="input-group flatpickr" id="flatpickr-date">
                                            <input type="text" class="form-control" id="tanggal_mulai" name="tanggal_mulai" data-input required>
                                            <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="userEmail" class="form-label">Tanggal Selesai</label>
                                        <div class="input-group flatpickr" id="flatpickr-date">
                                            <input type="text" class="form-control" id="tanggal_selesai" name="tanggal_selesai" data-input required>
                                            <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="userEmail" class="form-label">Nama Pembimbing</label>
                                        <input type="text" class="form-control" id="nama_pembimbing" name="nama_pembimbing" placeholder="Nama Lengkap dan Gelar">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="userEmail" class="form-label">Kontak Pembimbing</label>
                                        <input type="text" class="form-control" id="kontak_pembimbing" name="kontak_pembimbing" placeholder="No. HP">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <label for="userEmail" class="form-label">Perbaiki Berkas</label>
                                        <select name="status_permohonan" class="form-control" id="status_permohonan">
                                            <option value="0">Permohonan Diajukan</option>
                                            <option value="1">Berkas Diterima</option>
                                            <option value="2">Permohonan Dikoordinasikan</option>
                                            <option value="3">Dalam Proses</option>
                                            <option value="4">Permohonan Disetujui</option>
                                            <option value="5">Permohonan Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" id="update_permohonan" class="btn btn-success me-2">Simpan Perubahan</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/dropify.js') }}"></script>
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var baseUrl = '{{ url('/') }}';

        $('#editRequestLitbang').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var riwayatJabatanId = button.data('id');
            var url = baseUrl + '/sindikat/request_litbang/edit/' + riwayatJabatanId;
            
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data.pemohon);
                    $('#judul_penelitian').val(data.judul_penelitian);
                    $('#bidang_penelitian').val(data.bidang_penelitian);
                    $('#deskripsi_penelitian').val(data.deskripsi_penelitian);
                    $('#tanggal_mulai').val(data.tanggal_mulai);
                    $('#tanggal_selesai').val(data.tanggal_selesai);
                    $('#nama_pembimbing').val(data.nama_pembimbing);
                    $('#kontak_pembimbing').val(data.kontak_pembimbing);
                    $('#status_permohonan').val(data.status_permohonan);

                    document.getElementById('nama_pemohon').innerHTML = data.pemohon.nama;
                    document.getElementById('nim').innerHTML = data.pemohon.nim;
                    document.getElementById('perguruan_tinggi').innerHTML = data.pemohon.perguruan_tinggi;
                    document.getElementById('fakultas').innerHTML = data.pemohon.fakultas;
                    document.getElementById('program_studi').innerHTML = data.pemohon.program_studi;
                    document.getElementById('no_hp').innerHTML = data.pemohon.no_hp;
                    document.getElementById('surel').innerHTML = data.pemohon.email;
                    document.getElementById('passcode').innerHTML = data.pemohon.passcode;

                    var formAction = "{{ route('sindikat.request_litbang.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editRequestLitbangForm').attr('action', formAction);

                    var embedSrc = baseUrl + '/storage/sindikat/permohonan_litbang/' + data.permohonan_litbang_id + '/' + data.berkas_pendukung;
                    $('#dokumen_embed').attr('src', embedSrc);
                    },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>