<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RSUD Brebes Karir</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <header>
            <div class="row">
                <nav class="navbar bg-body-tertiary">
                    <div class="container">
                        <a class="navbar-brand" href="#">
                        <img src="https://pbs.twimg.com/media/FBKSVOeVcAcrXlB.jpg" alt="Karir RSUD Brebes" height="40">
                        RSUD Brebes - Karir 2025
                        </a>
                    </div>
                </nav>
            </div>
        </header>
        <section>
            @if ($peserta != null)
                
            <div class="container">
                <div class="card mt-5">
                    <h5 class="card-header bg-success text-white">Verifikasi Identitas Pelamar</h5>
                    <div class="card-body">
                        <img src="{{url('/storage/foto_peserta_karir/'.$peserta->foto)}}" width="250px" alt="" srcset=""> <br>

                        @if ($peserta == "1")
                            <p class="text-danger text-center mt-4 mb-4">Alamat Email atau NIK yang Anda daftarkan tidak cocok, Pastikan Alamat email dan NIK sesuai dengan data ketika melamar.</p>
                        @elseif ($peserta == "2")
                            <p class="text-center mt-4 mb-4">Bagi Anda yang sudah lolos silahkan isi alamat Email dan NIK untuk mendapatkan Nomor Peserta</p>
                        @else
                        
                            @php
                            try {
                                $formattedDate = \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y');
                            } catch (\Exception $e) {
                                $formattedDate = $peserta->tanggal_lahir;
                            }
                        @endphp
                        <div class="row mt-3 p-3">

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="">Nomor Peserta</label>
                                    <span class="form-control">{{$peserta->no_peserta}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Nama</label>
                                    <span class="form-control">{{$peserta->nama}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">NIK</label>
                                    <span class="form-control">{{$peserta->nik}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Email</label>
                                    <span class="form-control">{{$peserta->email}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Jenis Kelamin</label>
                                    <span class="form-control">{{$peserta->jenis_kelamin}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="">Formasi yang Dilamar</label>
                                    <span class="form-control">{{$peserta->formasi}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Jenjang Pendidikan</label>
                                    <span class="form-control">{{$peserta->jenjang}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Tempat Lahir</label>
                                    <span class="form-control">{{$peserta->tempat_lahir}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Tanggal Lahir</label>
                                    <span class="form-control">{{ $formattedDate }}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Alamat</label>
                                    <span class="form-control">{{$peserta->alamat}}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="" class="mt-2"><strong>Informasi Ujian</strong></label>
                                <div class="form-group mb-1">
                                    <small for="">Tempat</small>
                                    <span class="form-control">{{$peserta->tempat_ujian}}</span>
                                </div>
                                <div class="form-group mb-1">
                                    <small for="">Tanggal</small>
                                    <span class="form-control">{{$peserta->tanggal_ujian}}</span>
                                </div>
                                <div class="form-group mb-1">
                                    <small for="">Sesi</small>
                                    <span class="form-control">{{$peserta->sesi_ujian}}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="container mt-5">
                <div class="row text-center">
                    <h1>404</h1>
                    <h4>Data Peserta Tidak Ditemukan</h4>
                </div>
            </div>
            @endif

        </section>
        <footer>
            <div class="container mt-4 text-center">
                <small>Team IT RSUD Brebes 2025</small>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
