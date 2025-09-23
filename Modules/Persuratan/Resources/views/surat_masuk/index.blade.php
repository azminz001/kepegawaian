@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Persuratan</li>
        <li class="breadcrumb-item active" aria-current="page">Surat Masuk</li>
    </ol>
</nav>
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
                            <h6 class="card-title mb-0">DAFTAR SURAT MASUK RSUD BREBES</h6>            
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3 middle-wrapper">
                                <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahSurat"><i data-feather="plus"></i> TAMBAH SURAT</button>
                            </div>
                            <div class="col-sm-12 col-md-9 middle-wrapper">
                                <form action="{{ route('persuratan.surat_masuk.cari') }}">
                                    @csrf
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        </div>
                                        <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="cari nomor surat">
                                        <button type="submit" class="btn btn-secondary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 middle-wrapper">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">NOMOR AGENDA</th>
                                        <th class="text-center">SURAT MASUK</th>
                                        <th class="text-center">TANGGAL TERIMA</th>
                                        <th class="text-center">DISPOSISI</th>
                                        <th class="text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($surats as $surat)
                                    <tr>
                                        <td width="7%">{{$surat->id}}</td>
                                        <td>
                                            Nomor : {{$surat->nomor}} <br> 
                                            Perihal : <b>{{$surat->perihal}}</b> <br>
                                            Sifat : {{$surat->sifat}} <br>
                                            Dari : {{$surat->dari}} <br>
                                            Tanggal : {{$surat->tanggal_surat}} <br>
                                            Disposisi : {{$surat->disposisi}}
                                        </td>
                                        <td>{{$surat->tanggal_terima}}</td>
                                        <td>{{$surat->disposisi}}</td>
                                        <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin mengahapus surat ini?');" action="{{ route('persuratan.surat_masuk.destroy', $surat->id) }}" method="POST">
                                                <button type="button" class="btn btn-default btn-xs btn-icon" onclick="showPDFInModal(`{{ asset('storage/persuratan/surat_masuk/' . $surat->file) }}`)" data-toggle="tooltip" title="lihat surat">
                                                    <i data-feather="eye"></i>
                                                </button>
                                                <button onclick="cetakDisposisi('{{ $surat->id }}')" type="button" class="btn btn-primary btn-xs btn-icon" 
                                                        data-toggle="tooltip" title="Cetak Disposisi">
                                                    <i data-feather="printer"></i>
                                                </button>

                                                <button type="button" class="btn btn-warning btn-xs btn-icon" data-bs-toggle="modal" data-bs-target="#editSurat{{$surat->id}}" data-toggle="tooltip" title="edit">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs btn-icon" data-toggle="tooltip" title="hapus">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                                <ul class="pagination justify-content-center">
                                    {{ $surats->onEachSide(0)->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                                <small>Menampilkan {{$surats->count()}} data surat masuk dari total {{$surat_count}} surat masuk.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>

<!-- Modal untuk menampilkan PDF -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="pdfModalLabel">FILE PDF SURAT MASUK</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="pdf-container">
            <!-- Canvas for PDF pages will be added dynamically here -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahSurat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">FORM TAMBAH SURAT MASUK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('persuratan.surat_masuk.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NOMOR SURAT *</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nomor" value="" placeholder="Masukkan nomor surat masuk" required>
                                    @error('nomor')
                                        <code>{{$nomor}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">SIFAT SURAT *</label>
                                    <select name="sifat" class="form-control" data-width="100%" required>
                                        <option value="" disabled selected>-- PILIH SIFAT --</option>
                                        <option value="BIASA">BIASA</option>
                                        <option value="SEGERA">SEGERA</option>
                                        <option value="AMAT SEGERA">AMAT SEGERA</option>
                                        <option value="RAHASIA">RAHASIA</option>
                                        <option value="TERBATAS">TERBATAS</option>
                                    </select>
                                    @error('sifat')
                                        <code>{{$sifat}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">PERIHAL *</label>
                                    <textarea name="perihal" id="" class="form-control" id="exampleInputUsername1" autocomplete="off" value="" placeholder="Masukkan perihal surat" required></textarea>
                                    @error('perihal')
                                        <code>{{$perihal}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">ASAL SURAT *</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="dari" value="" placeholder="Masukkan darimana surat berasal" required>
                                    @error('dari')
                                        <code>{{$dari}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TANGGAL SURAT *</label>
                                    <input type="date" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tanggal_surat" required>
                                    @error('tanggal_surat')
                                        <code>{{$tanggal_surat}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TANGGAL TERIMA *</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tanggal_terima" value="" placeholder="{{ date('Y/m/d') }}" disabled>
                                    @error('tanggal_terima')
                                        <code>{{$tanggal_terima}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">UPLOAD FILE SURAT *</label>
                                    <small class="text-danger">PDF max 2MB</small>
                                    <input type="file" class="form-control" name="file" accept="application/pdf" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_user" value="437">
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach ($surats as $surat)
<div class="modal fade" id="editSurat{{$surat->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Ubah Data Surat Masuk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('persuratan.surat_masuk.update', $surat->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">NOMOR SURAT *</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nomor" value="{{ $surat->nomor }}" placeholder="Masukkan nomor surat masuk" required>
                                    @error('nomor')
                                        <code>{{$nomor}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">SIFAT SURAT *</label>
                                    <select name="sifat" class="form-control" data-width="100%" required>
                                        <option value="{{ $surat->sifat }}" selected>{{ $surat->sifat }}</option>
                                        <option value="BIASA">BIASA</option>
                                        <option value="SEGERA">SEGERA</option>
                                        <option value="AMAT SEGERA">AMAT SEGERA</option>
                                        <option value="RAHASIA">RAHASIA</option>
                                        <option value="TERBATAS">TERBATAS</option>
                                    </select>
                                    @error('sifat')
                                        <code>{{$sifat}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">PERIHAL *</label>
                                    <textarea name="perihal" id="" class="form-control" id="exampleInputUsername1" autocomplete="off" placeholder="Masukkan perihal surat" required>{{ $surat->perihal }}</textarea>
                                    @error('perihal')
                                        <code>{{$perihal}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">ASAL SURAT *</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="dari" value="{{ $surat->dari }}" placeholder="Masukkan darimana surat berasal" required>
                                    @error('dari')
                                        <code>{{$dari}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TANGGAL SURAT *</label>
                                    <input type="date" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tanggal_surat" value="{{ $surat->tanggal_surat }}" required>
                                    @error('tanggal_surat')
                                        <code>{{$tanggal_surat}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">TANGGAL TERIMA *</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="tanggal_terima" placeholder="{{ $surat->tanggal_terima }}" disabled>
                                    @error('tanggal_terima')
                                        <code>{{$tanggal_terima}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">UPLOAD FILE SURAT *</label>
                                    <small class="text-danger">PDF max 2MB</small>
                                    <input type="file" class="form-control" name="file" accept="application/pdf">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Disposisi</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="disposisi" value="{{ $surat->disposisi }}" placeholder="Disposisi kepada ..." required>
                                    @error('disposisi')
                                        <code>{{$disposisi}}</code>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_user" value="437">
                    <button type="submit" class="btn btn-success me-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach ($surats as $surat)
<div id="disposisi-{{ $surat->id }}" class="disposisi-content" style="display: none;">
    <table width="100%">
        <tbody>
            <tr>
                <td width="12%"><img src="{{ asset('assets/images/LogoKabupatenBrebes.png') }}" width="100%"></td>
                <td>
                    <p style="font-family: 'Bookman Old Style', serif; font-size: 13pt; text-align: center; font-weight: bold;">
                        PEMERINTAH KABUPATEN BREBES<br>
                        DINAS KESEHATAN DAERAH<br>
                        UNIT ORGANISASI BERSIFAT KHUSUS RSUD BREBES<br>
                    </p>
                    <p style="font-family: 'Bookman Old Style', serif; font-size: 7pt; text-align: center;">
                    Jalan Jenderal Sudirman Nomor 181 Brebes Telepon (0283) 671431 Faksimile (0283) 671095
                    </p>
                    <p style="font-family: 'Bookman Old Style', serif; font-size: 7pt; text-align: center;">
                    Pos-el rsudbrebes@gmail.com
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <hr style="border: none; border-top: 4px solid black; margin: 0;">
    <br>
    <p style="font-family: 'Bookman Old Style', serif; font-size: 9pt; text-align: center;">
        DISPOSISI ATAS SURAT
    </p>
    <br>
    <!-- Konten disposisi yang akan diupdate berdasarkan ID -->
    <table width="100%" style="font-family: 'Bookman Old Style', serif; font-size: 9pt;">
        <tbody>
            <tr>
                <td width="12%">Surat Dari</td>
                <td> : </td>
                <td>{{ $surat->dari }}</td>
                <td width="15%">Tanggal Terima</td>
                <td> : </td>
                <td>{{ $surat->tanggal_terima }}</td>
            </tr>
            <tr>
                <td>Nomor Surat</td>
                <td> : </td>
                <td>{{ $surat->nomor }}</td>
                <td>Nomor Agenda</td>
                <td> : </td>
                <td>{{ $surat->id }}</td>
            </tr>
            <tr>
                <td>Perihal</td>
                <td> : </td>
                <td>{{ $surat->perihal }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table style="font-family: 'Bookman Old Style', serif; font-size: 9pt;">
        <tbody>
            <tr>
                <td align="left" width="15%">Sifat : </td>
                <td align="left" width="15%"><input type="text" style="border-color:#000; text-align:center" size="1"> Biasa</td>
                <td align="left" width="15%"><input type="text" style="border-color:#000; text-align:center" size="1"> Segera</td>
                <td align="left" width="15%"><input type="text" style="border-color:#000; text-align:center" size="1"> Amat Segera</td>
                <td align="left" width="15%"><input type="text" style="border-color:#000; text-align:center" size="1"> Rahasia</td>
                <td align="left" width="15%"><input type="text" style="border-color:#000; text-align:center" size="1"> Terbatas</td>
            </tr>
        </tbody>
    </table>
    <br>
    <p style="font-family: 'Bookman Old Style', serif; font-size: 9pt;">Diteruskan Kepada :</p>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="font-family: 'Bookman Old Style', serif; font-size: 9pt;">
        <tbody>
            <tr>
                <td width="50%">
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Wadir Umum dan Keuangan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Wadir Pelayanan, Pengendalian, dan Mutu<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kabid Medis<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kabid Keperawatan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kabid Penunjang<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kabag Keuangan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kabag Umum dan Tata Usaha<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kabag Perencanaan<br>
                    <br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasie Pelayanan Medis<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasie Pengembangan Mutu Pelayanan Medis<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasie Pelayanan Keperawatan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasie Pengendalian Mutu Pelayanan Keperawatan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasie Pelayanan Penunjang Medis<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasie Pelayanan Penunjangn Non Medis<br>
                </td>
                <td width="50%">
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Perencanaan Anggaran<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Pendapatan dan Perbendaharaan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Akutansi dan Verifikasi<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Administrasi Umum dan Kepegawaian<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Kemitraan, Humas, dan Hukum<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Sarana dan Pengadaan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Perencanaan dan Evaluasi Program<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Mutu SDM, Diklat, dan Litbang<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kasubag Inovasi, Teknologi dan Digitalisasi<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Ketua Komite Medis<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Ketua Komite Keperawatan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Ketua SPI<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kepala SMF ...........................<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kepala Instalasi .....................<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Kepala Ruang / Bangsal ...............<br>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <p style="font-family: 'Bookman Old Style', serif; font-size: 9pt; text-align: center;">
        ISI DISPOSISI
    </p>
    <br>
    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="font-family: 'Bookman Old Style', serif; font-size: 9pt;">
        <tbody>
            <tr>
                <td width="50%">
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Untuk diketahui<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Pelajari dan ajukan saran<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Laksanakan sesuai petunjuk<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Proses sesuai prosedur<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Selesaikan segera/sebelum tgl ........<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Teruskan/Salurkan ke .................<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Simpan dalam file<br>
                </td>
                <td width="50%">
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Hadir mewakili saya<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Bicarakan dengan saya<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Siapkan jawaban/bahan<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Hadir/tunjuk wakil<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Copy untuk ...........................<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Koordinasikan ........................<br>
                    <input type="text" style="border-color:#000; text-align:center" size="1"> Sebagai Pedoman<br>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <p style="font-family: 'Bookman Old Style', serif; font-size: 9pt; text-align: center;">
       CATATAN
    </p>
    <br>
    <table style="border: 1px solid black; border-collapse: collapse; font-family: 'Bookman Old Style', serif; font-size: 9pt; text-align: center; font-weight: bold; width: 100%;">
        <tbody>
            <tr>
                <td style="border: 1px solid black;">DIREKTUR</td>
                <td width="30%" style="border: 1px solid black;">KABID / KABAG</td>
            </tr>
            <tr style="height: 150px;">
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
            </tr>
            <tr>
                <td width="30%" style="border: 1px solid black;">WADIR</td>                
                <td width="30%" style="border: 1px solid black;">KASIE / KASUBAG</td>
            </tr>
            <tr style="height: 150px;">
                <td style="border: 1px solid black;"></td>
                <td style="border: 1px solid black;"></td>
            </tr>
        </tbody>
    </table>
</div>
@endforeach

@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush

<script src="{{ asset('assets/js/pdf/pdf.js') }}"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('assets/js/pdf/pdf.worker.js') }}";

    function showPDFInModal(pdfUrl) {
        const url = pdfUrl;

        // Clear previous content
        const container = document.getElementById('pdf-container');
        container.innerHTML = '';

        // Load the PDF
        pdfjsLib.getDocument(url).promise.then(function(pdf) {
            const numPages = pdf.numPages;

            // Get the container width
            const containerWidth = document.querySelector('#pdfModal .modal-body').clientWidth;

            // Loop through all pages
            for (let pageNum = 1; pageNum <= numPages; pageNum++) {
                pdf.getPage(pageNum).then(function(page) {
                    const viewport = page.getViewport({ scale: 1 });
                    
                    // Calculate scale to fit the width
                    const scale = containerWidth / viewport.width;
                    const scaledViewport = page.getViewport({ scale: scale });

                    // Create a canvas for each page
                    const canvas = document.createElement('canvas');
                    const context = canvas.getContext('2d');
                    canvas.width = scaledViewport.width;
                    canvas.height = scaledViewport.height;
                    container.appendChild(canvas);

                    const renderContext = {
                        canvasContext: context,
                        viewport: scaledViewport
                    };
                    page.render(renderContext);
                });
            }
        }, function(reason) {
            console.error('Error loading PDF: ' + reason);
        });

        // Show the PDF modal
        var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'), {});
        pdfModal.show();
    }

    // Data disposisi dari Blade yang sudah di-encode menjadi JSON
    var disposisiData = <?php echo json_encode($surats); ?>;

    function cetakDisposisi(suratId) {
        // Dapatkan elemen disposisi yang akan dicetak berdasarkan ID surat
        var disposisi = document.getElementById('disposisi-' + suratId);

        // Tampilkan elemen disposisi (jika sebelumnya disembunyikan)
        disposisi.style.display = 'block';

        // Simpan referensi ke elemen body asli
        var originalContent = document.body.innerHTML;

        // Ganti isi body dengan konten disposisi yang akan dicetak
        document.body.innerHTML = disposisi.outerHTML;

        // Jalankan perintah cetak
        window.print();

        // Kembalikan isi body ke konten asli setelah mencetak
        document.body.innerHTML = originalContent;

        // Reload halaman agar semua event listener kembali berfungsi
        window.location.reload();
    }

</script>
