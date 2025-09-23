
@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                    <div class="col-md-12 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-2">
                            <div class="row">
                                <div class="col-md-8 col-sm-12">
                                    <a href="{{url('/sindikat')}}" class="noble-ui-logo d-block mb-2 mt-5">SIN<span>DIKAT</span></a>
                                    <h6 class="text-muted fw-normal mb-2">Lengkapi Form Pendaftaran Akun Berikut</h6>
                                    <h4 class="mt-5">Form Permohonan Penelitian dan Pengembangan</h4>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <img src="https://img.freepik.com/free-vector/online-doctor-with-white-coat_23-2148519127.jpg" width="300px" alt="" class="img-fluid" srcset="">
                                </div>
                            </div>
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> {{ session('success') }}.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                            </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('sindikat.litbang.request_account')}}">
                                @csrf
                                <div class="mb-3">
                                    <label for="userEmail" class="form-label">Nama Pemohon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap Tanpa Gelar" required>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="userEmail" class="form-label">NIM <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nim" placeholder="Nomor Induk Mahasiswa" required>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="userEmail" class="form-label">Perguruan Tinggi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="perguruan_tinggi" placeholder="Nama Perguruan Tinggi" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="userEmail" class="form-label">Fakultas</label>
                                        <input type="text" class="form-control" name="fakultas" placeholder="Nama Fakultas">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="userEmail" class="form-label">Program Studi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="program_studi" placeholder="Nama Program Studi" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-5">
                                        <div class="">
                                            <label for="userEmail" class="form-label">No. HP (WhatsApp Notifikasi) <span class="text-danger">*</span></label>
                                            <input type="telp" class="form-control" name="no_hp" placeholder="contoh: 0857xxxxxxxx" required>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="">
                                            <label for="userEmail" class="form-label">Email Pemohon <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="email" placeholder="Email Aktif Pemohon" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 mt-3">
                                    <div class="form-check">
                                        <label class="form-check-label" for="termsCheck">
                                            Saya setuju terkait Syarat dan Ketentuan sebagai Peneliti / Pengembang di RSUD Brebes. <a href="#" data-bs-toggle="modal" data-bs-target="#termResearcher">(Baca S&K)</a>
                                        </label>
                                        <input type="checkbox" class="form-check-input" name="terms_agree" value="1" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3 pt-2">
                                    <div class="captcha">
                                        <span>{!! captcha_img() !!}</span>
                                    </div>
                                    <input id="captcha" type="text" class="form-control form-control-sm" placeholder="Captcha" name="captcha" required>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0" >Daftar</button>
                                    <p class="mt-3">Sudah memiliki Akun Peneliti? Silahkan <a href="{{route('sindikat.litbang.login')}}">Login</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="termResearcher" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Syarat dan Ketentuan Permohonan Penelitian Mahasiswa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body p-4">
            <div class="terms-and-conditions">
                <p>Dengan mengajukan permohonan penelitian di Rumah Sakit <strong>RSUD BREBES</strong>, mahasiswa dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan berikut ini:</p>
            
                <h5 class="mt-2">1. Persyaratan Umum</h5>
                <ul>
                    <li>Mahasiswa harus berasal dari institusi pendidikan resmi yang terakreditasi.</li>
                    <li>Permohonan wajib dilampiri dengan:
                        <ul>
                            <li>Surat pengantar resmi dari institusi pendidikan.</li>
                            <li>Surat Pernyataan Tanggung Jawab Penelitian.</li>
                            <li>Proposal penelitian lengkap.</li>
                        </ul>
                    </li>
                    <li>Data pribadi dan informasi yang diberikan harus akurat dan dapat dipertanggungjawabkan.</li>
                </ul>
            
                <h5 class="mt-1">2. Proses Permohonan</h5>
                <ul>
                    <li>Permohonan diajukan melalui sistem yang telah disediakan oleh Rumah Sakit <strong>RSUD BREBES</strong>.</li>
                    <li>Waktu minimal pengajuan permohonan adalah <strong> 2 minggu</strong> sebelum tanggal rencana penelitian.</li>
                    <li>Permohonan akan melalui proses seleksi administratif dan teknis, dan keputusan rumah sakit bersifat <strong>final dan mengikat</strong>.</li>
                </ul>
            
                <h5 class="mt-1">3. Hak dan Kewajiban Mahasiswa</h5>
                <ul>
                    <li>Mahasiswa wajib menjaga kerahasiaan seluruh data pasien dan informasi rumah sakit sesuai dengan ketentuan hukum yang berlaku.</li>
                    <li>Mahasiswa tidak diperbolehkan mengambil data pasien tanpa izin resmi.</li>
                    <li>Mahasiswa bertanggung jawab atas seluruh aktivitas selama masa penelitian di lingkungan rumah sakit.</li>
                    <li>Mahasiswa wajib mematuhi seluruh peraturan, tata tertib, dan protokol keselamatan yang berlaku.</li>
                </ul>
            
                <h5 class="mt-1">4. Penggunaan Data dan Publikasi</h5>
                <ul>
                    <li>Data yang diperoleh selama penelitian hanya boleh digunakan untuk kepentingan akademik sesuai proposal.</li>
                    <li>Publikasi hasil penelitian wajib mencantumkan nama Rumah Sakit <strong>RSUD BREBES</strong> dan menjaga kerahasiaan pasien.</li>
                    <li>Mahasiswa wajib menyerahkan satu eksemplar hasil penelitian ke Rumah Sakit.</li>
                </ul>
            
                <h5 class="mt-1">5. Larangan</h5>
                <ul>
                    <li>Dilarang melakukan dokumentasi foto/video tanpa izin resmi rumah sakit.</li>
                    <li>Dilarang menyalahgunakan data dan informasi untuk tujuan selain penelitian yang disetujui.</li>
                </ul>
            
                <h5 class="mt-1">6. Sanksi</h5>
                <ul>
                    <li>Pencabutan izin penelitian.</li>
                    <li>Pelaporan kepada institusi pendidikan.</li>
                    <li>Proses hukum sesuai peraturan perundang-undangan yang berlaku.</li>
                </ul>
            
                <h5 class="mt-1">7. Lain-lain</h5>
                <ul>
                    <li>Rumah Sakit <strong>RSUD BREBES</strong> berhak mengubah syarat dan ketentuan sewaktu-waktu tanpa pemberitahuan.</li>
                    <li>Hal-hal yang belum diatur akan ditentukan oleh pihak rumah sakit.</li>
                </ul>
            
                <p><strong>RSUD BREBES</strong><br>
                Jl. Jenderal Sudirman No.181, Pangembon, Brebes, Kec. Brebes, Kabupaten Brebes, Jawa Tengah<br>
                (0283) 671431<br>
                01 Mei 2025</p>
            </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Siap, Saya Paham</button>
            </div>
        </div>
    </div>
</div>
@endsection