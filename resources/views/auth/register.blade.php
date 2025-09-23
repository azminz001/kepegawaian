
@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row mx-2">
                    <div class="col-md-12  ps-md-0">
                        <div class="auth-form-wrapper px-4 py-3">
                            <a href="#" class="noble-ui-logo d-block mb-2 text-center mt-2">SIM-<span>RSUD</span></a>
                            <h5 class="text-muted fw-normal mb-5 text-center">Sistem Informasi Manajemen RSUD Brebes</h5>
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
                            <form action="{{ route('kepegawaian.register')}}" method="post">
                                @csrf
                                <div class="col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-md-5 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Status Kepegawaian Anda saat ini</label>
                                                <select name="status_kepegawaian" class="form-control" id="" required>
                                                    <option value="">- Pilih Status Kepegawaian -</option>
                                                    <option value="PNS">PNS</option>
                                                    <option value="PPPK">PPPK</option>
                                                    <option value="BLUD">Tenaga BLUD</option>
                                                    <option value="KONTRAK">Tenaga Kontrak</option>
                                                    <option value="MITRA">Tenaga Mitra</option>
                                                    <option value="LAINNYA">Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-7 col-sm-12">
                                            <div class="mb-3">
                                                <label for="" class="form-label">NIP/NIPPPK/NRPK/NRPBLUD</label>
                                                <input type="number" class="form-control" id="exampleInputUsername1" autocomplete="off" name="username" placeholder="Nomor Induk Pegawai RSUD Brebes" required>
                                                @error('username')
                                                    <code>{{$message}}</code>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="" class="form-label">Nama Lengkap dan Gelar</label><code>Kosongi Gelar jika tidak ada</code>
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12 mb-1">
                                                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="gelar_depan" placeholder="Gelar Depan">
                                            </div>
                                            <div class="col-md-6 col-sm-12 mb-1">
                                                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="nama" placeholder="Nama Lengkap" required>
                                            </div>
                                            <div class="col-md-3 col-sm-12 mb-1">
                                                <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="gelar_belakang" placeholder="Gelar Belakang">
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
                                    
                                    <div class="col-md-3 mb-3">
                                        <div class="captcha">
                                            <span>{!! captcha_img() !!}</span>
                                        </div>
                                        <input id="captcha" type="text" class="form-control form-control-sm" placeholder="Captcha" name="captcha" required>

                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0"><i class="mdi mdi-account-plus m-2"></i>Daftar</button>
                                    <a href="{{route('kepegawaian.login')}}"><button type="button" class="btn btn-secondary me-2 mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><i class="mdi mdi-login m-2"></i>Login</button></a>
                                </div>
                            </form>
                        </div>
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