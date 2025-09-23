
@extends('layout.master2')
@push('plugin-styles')
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="page-content d-flex align-items-center justify-content-center mt-3">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-10 col-xl-8 mx-auto">
            <div class="card">
                <div class="col-md-12 ps-md-0">
                    <div class="auth-form-wrapper px-4 py-2">
                        <form method="POST" action="{{ route('sindikat.litbang.update', $pemohon->id) }}">
                            @method('PUT')
                            @csrf
                            <a href="{{url('/sindikat')}}" class="noble-ui-logo d-block mb-2 mt-5">SIN<span>DIKAT</span></a>
                            <h6 class="text-muted fw-normal mb-2">Penelitian dan Pengembangan RSUD Brebes</h6>
                            <h4 class="mt-3 mb-3 text-center">Biodata Pemohon</h4>
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> {{ session('success') }}.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                            </div>
                            @endif
                            <div class="mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="userEmail" class="form-label">Nama Pemohon </label>
                                    <input type="text" class="form-control" name="nama" value="{{$pemohon->nama}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="userEmail" class="form-label">NIM </label>
                                    <input type="text" class="form-control" name="nim" value="{{$pemohon->nim}}">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="userEmail" class="form-label">Perguruan Tinggi </label>
                                    <input type="text" class="form-control" name="perguruan_tinggi" value="{{$pemohon->perguruan_tinggi}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 col-sm-12">
                                    <label for="userEmail" class="form-label">Fakultas</label>
                                    <input type="text" class="form-control" name="fakultas" value="{{$pemohon->fakultas}}">
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="userEmail" class="form-label">Program Studi </label>
                                    <input type="text" class="form-control" name="program_studi" value="{{$pemohon->program_studi}}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-5">
                                    <div class="">
                                        <label for="userEmail" class="form-label">No. HP (WhatsApp Notifikasi) </label>
                                        <input type="telp" class="form-control" name="no_hp"  value="{{$pemohon->no_hp}}">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="">
                                        <label for="userEmail" class="form-label">Email Pemohon </label>
                                        <input type="text" class="form-control" name="email"  value="{{$pemohon->email}}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Perbarui Biodata</button>
                        </form>
                    </div>
                </div>
                
                <div class="col-md-12 ps-md-0">
                    <div class="auth-form-wrapper px-4 py-2">
                        <h4 class="mt-3 mb-3">Data Permohonan Penelitan dan Pengembangan</h4>
                        <div class="alert alert-primary" role="alert">
                            <strong class="mb-2">Informasi!</strong>
                            <p class="mb-2">Tahapan Status Permohonan:</p>
                            <ul class="pagination pagination-rounded">
                                <li class="page-item"><span class="page-link bg-primary text-white">1. Diajukan</span></li>
                                <li class="page-item"><span class="page-link bg-success text-white">2. Berkas Diterima</span></li>
                                <li class="page-item"><span class="page-link bg-warning text-white">3. Dikoordinasikan</span></li>
                                <li class="page-item"><span class="page-link bg-primary text-white">4. Dalam Proses</span></li>
                                <li class="page-item"><span class="page-link bg-success text-white">5. Disetujui</span></li>
                                <li class="page-item"><span class="page-link bg-danger text-white">6. Ditolak</span></li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRequestLitbang">Buat Permohonan Baru</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="createRequestLitbang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Permohonan Penelitian Pengembangan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{route('sindikat.litbang.request_litbang')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <input type="hidden" class="form-control" name="permohonan_litbang_id" value="{{$pemohon->id}}">
                        <div class="col-md-9 col-sm-12">
                            <label for="userEmail" class="form-label">Judul Penelitian</label>
                            <input type="text" class="form-control" name="judul_penelitian" placeholder="">
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <label for="userEmail" class="form-label">Bidang Penelitian</label>
                            <select name="bidang_penelitian" class="form-control" id="">
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
                            <textarea name="deskripsi_penelitian" class="form-control" id="" cols="40" rows="3" placeholder="Deskripsi singkat rencana penelitian..."></textarea>
                        </div>
                    </div>
                    <h5 class="mb-2">Tanggal Rencana Penelitian</h5>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="userEmail" class="form-label">Tanggal Mulai</label>
                            <div class="input-group flatpickr" id="flatpickr-date">
                                <input type="text" class="form-control" name="tanggal_mulai" data-input required>
                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="userEmail" class="form-label">Tanggal Selesai</label>
                            <div class="input-group flatpickr" id="flatpickr-date">
                                <input type="text" class="form-control" name="tanggal_selesai" data-input required>
                                <span class="input-group-text input-group-addon" data-toggle><i data-feather="calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="userEmail" class="form-label">Nama Pembimbing</label>
                            <input type="text" class="form-control" name="nama_pembimbing" placeholder="Nama Lengkap dan Gelar">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="userEmail" class="form-label">Kontak Pembimbing</label>
                            <input type="text" class="form-control" name="kontak_pembimbing" placeholder="No. HP">
                        </div>
                    </div>
                    <div class="alert alert-primary" role="alert">
                        <strong>Berkas File Pendukung</strong>
                        <ol>
                            <li>Surat pengantar resmi dari institusi pendidikan.</li>
                            <li>Surat Pernyataan Tanggung Jawab Penelitian. <a href="#">Download Format</a></li>
                            <li>Proposal penelitian lengkap.</li>
                        </ol>
                        <p class="mb-2">Berkas digabungkan menjadi 1 PDF (Maks. 5 MB) sesuai urutan dan diunggah.</p>
                        <input type="file" class="form-control" name="file" accept="application/pdf" id="myDropify" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Buat Permohonan</button>
                </div>
            </form>
        </div>
    </div>
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
                            <div class="col-lg-6 col-sm-12">
                                <iframe id="dokumen_embed" type="application/pdf" width="100%" height="720px"></iframe>
                            </div>
                            <div class="col-lg-6 col-sm-12">
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
                                        <textarea name="deskripsi_penelitian" class="form-control" id="deskripsi_penelitian" cols="40" rows="5" placeholder="Deskripsi singkat rencana penelitian..."></textarea>
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
                                    <label for="userEmail" class="form-label">Perbaiki Berkas</label>
                                    <input type="file" class="form-control" name="file">
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
                    console.log(data);
                    $('#judul_penelitian').val(data.judul_penelitian);
                    $('#bidang_penelitian').val(data.bidang_penelitian);
                    $('#deskripsi_penelitian').val(data.deskripsi_penelitian);
                    $('#tanggal_mulai').val(data.tanggal_mulai);
                    $('#tanggal_selesai').val(data.tanggal_selesai);
                    $('#nama_pembimbing').val(data.nama_pembimbing);
                    $('#kontak_pembimbing').val(data.kontak_pembimbing);

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