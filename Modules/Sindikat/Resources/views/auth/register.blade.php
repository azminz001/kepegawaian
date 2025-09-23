
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
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <img src="https://edexec.co.uk/wp-content/uploads/2021/01/school-building-modern-thin-line-design-style-vector-illustration-vector-id1030995160.jpg" width="320px" alt="" class="img-fluid" srcset="">
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
                            <form method="POST" action="{{ route('sindikat.register_institusi')}}" enctype="multipart/form-data">
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
                                    <div class="col-3">
                                        <div class="">
                                            <label for="userEmail" class="form-label">No. Telp</label>
                                            <input type="telp" class="form-control" name="telp" placeholder="No. Telp. Institusi" required>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="">
                                            <label for="userEmail" class="form-label">Email Institusi</label>
                                            <input type="text" class="form-control" name="email" placeholder="Email Institusi" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="">
                                            <label for="userEmail" class="form-label">No. WA PIC</label>
                                            <input type="telp" class="form-control" name="no_wa" placeholder="Nomor WhatsApp PIC (eg. 08xxxx)" required>
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
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" autocomplete="off" id="password" placeholder="Masukkan Password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" autocomplete="off" id="confirm_password" placeholder="Ulangi Password" required onkeyup="validate_password()">
                                            <span id="wrong_pass_alert"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 mt-3">
                                    <div class="form-check">
                                        <label class="form-check-label" for="termsCheck">
                                            Syarat dan Ketentuan aplikasi Sindikat mengatur pengumpulan data institusi, peserta didik, serta kegiatan pendidikan dan pelatihan untuk pengelolaan dan arsip internal RSUD. Pengguna setuju bahwa data yang dikumpulkan akan digunakan untuk kepentingan internal dengan menjaga kerahasiaannya sesuai peraturan. Pengguna bertanggung jawab atas keakuratan data, sementara RSUD berkomitmen melindungi informasi dari akses tidak sah sesuai undang-undang perlindungan data.
                                        </label>
                                        <input type="checkbox" class="form-check-input" name="terms_agree" id="termsCheck" required>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0" id="simpanButton" disabled>Daftar</button>
                                    <p class="mt-3">Sudah memiliki Akun? Silahkan <a href="{{url('/sindikat/login')}}">Login</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</div>

@endsection
<script>
    function validate_password() {
        let pass = document.getElementById('password').value;
        let confirm_pass = document.getElementById('confirm_password').value;
        let alertSpan = document.getElementById('wrong_pass_alert');
        let simpanButton = document.getElementById('simpanButton');
  
        if (pass != confirm_pass) {
            alertSpan.style.color = 'red';
            alertSpan.innerHTML = 'Password / Kata Sandi Belum Cocok';
            simpanButton.disabled = true; // Tombol Simpan dinonaktifkan jika password tidak cocok
        } else {
            alertSpan.style.color = 'green';
            alertSpan.innerHTML = 'Password / Kata Sandi Cocok';
            simpanButton.disabled = false; // Tombol Simpan diaktifkan jika password cocok
        }
    }
  </script>