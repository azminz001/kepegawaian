
@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-4 pe-md-0">
                        <div class="auth-side-wrapper" style="background-image: url({{ url('/assets/images/login-image.png') }})">

                        </div>
                    </div>
                <div class="col-md-8 ps-md-0">
                    <div class="auth-form-wrapper px-4 py-5">
                        
                        <a href="#" class="noble-ui-logo d-block mb-2 text-center">SIM-<span>RSUD</span></a>
                        <h5 class="text-muted fw-normal mb-4 text-center">Sistem Informasi Manajemen RSUD Brebes</h5>
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
                                <input type="text" class="form-control" name="username" placeholder="NIP/NIPPPK/NRP">
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="captcha">
                                    <span>{!! captcha_img() !!}</span>
                                </div>
                                <input id="captcha" type="text" class="form-control form-control-sm" placeholder="Captcha" name="captcha" required>

                            </div>
                            @if($errors->has('login_error'))
                                <code>{{ $errors->first('login_error') }}</code>
                            @endif
                            <div>
                                <button type="submit" class="btn btn-primary me-2 mb-2 mb-md-0"><i class="mdi mdi-login m-2"></i>Login</button>
                                <a href="{{route('kepegawaian.registerForm')}}"><button type="button" class="btn btn-secondary me-2 mb-2 mb-md-0" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><i class="mdi mdi-account-plus m-2"></i>Daftar</button></a>
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