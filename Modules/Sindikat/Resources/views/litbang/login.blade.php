
@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-6 pe-md-0">
                        <div class="auth-side-wrapper" style="background-image: url({{ url('https://img.freepik.com/free-vector/scientist-female-illustration-concept_23-2148413589.jpg') }})">

                        </div>
                    </div>
                <div class="col-md-6 ps-md-0">
                    <div class="auth-form-wrapper px-4 py-5">
                        
                        <a href="{{url('/sindikat')}}" class="noble-ui-logo d-block mb-2 text-center">SIN<span>DIKAT</span></a>
                        <h5 class="text-muted mt-2 mb-4 text-center"><strong>Permohonan Penelitian Pengembangan</strong></h5>
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
                        <form method="POST" action="{{ route('sindikat.litbang.login_process') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="Email Pemohon">
                            </div>
                            <div class="mb-3">
                                <label for="userPassword" class="form-label">Passcode</label>
                                <input type="number" name="passcode" class="form-control" placeholder="Passcode">
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
                                <p class="mt-3">Ingin mengajukan permohonan litbang?</p> Silahkan <a href="{{route('sindikat.litbang.create_account')}}">Daftar Permohonan Baru</a>
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