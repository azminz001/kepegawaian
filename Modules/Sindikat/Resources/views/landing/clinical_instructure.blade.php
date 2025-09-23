@extends('layout.master_sindikat')
    <style>
        .card-img-wrapper .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3); /* 0.4 = 40% gelap */
            z-index: 1;
        }

        /* Supaya teks tetap di atas overlay */
        .card-body {
            position: relative;
            z-index: 2;
        }
    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@section('content')
<div class="container py-5">
    <h3 class="text-center text-primary">SINDIKAT</h3>
    <h5 class="text-center mb-5">PROFIL INSTRUKTUR KLINIS RSUD BREBES</h5>
    <div class="container">
        <div class="row">
            @forelse ($pegawais as $pegawai)
                <div class="col-md-3 mb-4 px-3">
                    <div class="card h-100">
                        <div class="card-img-wrapper" style="height: 400px; overflow: hidden; position: relative;">
                            @if ($pegawai->foto == null)
                            <img src="{{ asset('assets/images/user-icon.png') }}" class="card-img-top img-fluid" 
                            alt="{{ $pegawai->nama }}" 
                            style="height: 100%; width: 100%; object-fit: cover; object-position: center;">
                            @else
                            <img src="{{ asset('storage/foto_pegawai/'.$pegawai->nip_nipppk_nrpk_nrpblud.'/'.$pegawai->foto) }}" class="card-img-top img-fluid" 
                            alt="{{ $pegawai->nama }}" 
                            style="height: 100%; width: 100%; object-fit: cover; object-position: center;">
                            @endif
                            <div class="overlay"></div>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                {{ $pegawai->gelar_depan ? $pegawai->gelar_depan.'. ' : '' }}{{ $pegawai->nama }}{{ $pegawai->gelar_belakang ? ', '.$pegawai->gelar_belakang : '' }}
                            </h5>
                            <strong>{{$pegawai->unit_jabatan_aktif->nama_unit}}</strong>
                            <p>{{$pegawai->jabatan_aktif->nama_jabatan}}</p>
                        </div>
                    </div>
                </div>
            @empty
                <p>No data found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
