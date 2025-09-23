
@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-5 pe-md-0">
                        <div class="auth-side-wrapper" style="background-image: url({{ url('https://img.freepik.com/free-vector/tiny-people-listening-doctor-recommendations-from-mobile-phone-cartoon-illustration_74855-14541.jpg') }})">

                        </div>
                    </div>
                <div class="col-md-7 ps-md-0">
                    <div class="auth-form-wrapper px-4 py-5">
                        
                        <a href="{{url('/sindikat')}}" class="noble-ui-logo d-block mb-2 text-center">SIN<span>DIKAT</span></a>
                        <h5 class="text-muted fw-normal text-center">Sistem Informasi Pendidikan Pelatihan dan Penelitian</h5>
                        <h5 class="text-muted mt-2 mb-4 text-center"><strong>RSUD Brebes</strong></h5>
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
                        <form method="POST" action="{{ route('kepegawaian.login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Email Institusi">
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            @if($errors->has('login_error'))
                                <code>{{ $errors->first('login_error') }}</code>
                            @endif
                            <div class="col-md-4 mb-3 pt-2">
                                <div class="captcha">
                                    <span>{!! captcha_img() !!}</span>
                                </div>
                                <input id="captcha" type="text" class="form-control form-control-sm" placeholder="Captcha" name="captcha" required>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0"><i class="mdi mdi-login m-2"></i>Login</button>
                                <p class="mt-3">Belum memiliki Akun?</p> Silahkan <a href="{{url('/sindikat/register')}}">Daftar sebagai Institusi</a>
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