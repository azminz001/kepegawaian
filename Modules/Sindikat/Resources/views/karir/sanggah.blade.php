<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RSUD Brebes Karir</title>
        <link rel="icon" href="https://rsud.brebeskab.go.id/wp-content/uploads/2022/10/fav-rs-brebes.png" sizes="32x32" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            #printKartu {
                width: auto; /* Biarkan elemen mengikuti ukuran kontennya */
                max-width: 100%; /* Hindari pembatasan lebar */
                margin: 0 auto;
                padding: 20px;
                box-sizing: border-box;
            }
        </style>
    </head>
    <body style="background-color: #F5F5F5">
        @php
            $datetimeNow = \Carbon\Carbon::now('Asia/Jakarta');
            $deadline = \Carbon\Carbon::create(2025, 3, 20, 12, 0, 0, 'Asia/Jakarta');
            $publish_response = \Carbon\Carbon::create(2025, 3, 21, 0, 1, 0, 'Asia/Jakarta');
            $deadline_sanggah = \Carbon\Carbon::create(2025, 3, 22, 23, 59, 59, 'Asia/Jakarta');
        @endphp
        <header>
            <div class="row">
                <nav class="navbar " style="background-color: #E7D283">
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
            @if ($datetimeNow->greaterThan($deadline_sanggah))
            <div class="container">
                <div class="card mt-3">
                    <h5 class="card-header text-white p-3" style="background-color:  #EB5A3C;border-radius: 0px">Sanggah Pasca CAT, Verifikasi Keaslian Dokumen dan Pemeriksaan Kesehatan</h5>
                    <div class="card-body" style="background-color:#F5F5F5">
                        <div class="alert alert-primary" role="alert">
                            <strong>Informasi!</strong>
                            <p>Sesuai dengan pengumuman Jawaban sanggahan hanya dapat dilihat mulai hari Jum'at tanggal 21 Maret 2025</p>
                            <strong>RSUD Brebes</strong>
                        </div>
                    </div>
                </div>
            </div>
            @else

            <div class="container">
                <div class="card mt-3">
                    <h5 class="card-header text-white p-3" style="background-color:  #EB5A3C;border-radius: 0px">Sanggah Pasca CAT, Verifikasi Keaslian Dokumen dan Pemeriksaan Kesehatan</h5>
                    <div class="card-body" style="background-color:#F5F5F5">
                        <h4 class="card-text text-center mt-3 mb-4">Input Email dan NIK dengan benar.</h4>
                        <form action="{{ route('karir.filter_sanggah') }}">
                            <div class="row p-4"> 
                                <div class="col-md-6 col-sm-12 mb-4">
                                    <div class="form-group">
                                        <input type="text"class="form-control form-control-lg" name="email" id="" aria-describedby="helpId" placeholder="Input Email Anda yang didaftarkan" style="border-radius: 0px">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-4">
                                    <div class="form-group">
                                        <input type="text"class="form-control form-control-lg" name="nik" id="" aria-describedby="helpId" placeholder="Input NIK Anda yang didaftarkan" style="border-radius: 0px">
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 col-6 mx-auto mt-3 mb-3">
                                <button type="submit" class="btn btn-primary btn-lg" style="background-color: #DF9755;border-color: #E7D283; border-radius: 0px">Buka Data</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-5">
                    <h5 class="card-header text-white p-3" style="background-color:  #EB5A3C;border-radius: 0px">Identitas Peserta</h5>
                    <div class="card-body" style="background-color:#F5F5F5">
                        @if ($peserta == "1")
                            <p class="text-danger text-center mt-4 mb-4">Alamat Email atau NIK yang Anda daftarkan tidak cocok, Pastikan Alamat email dan NIK sesuai dengan data ketika melamar.</p>
                        @elseif ($peserta == "2")
                            <p class="text-center mt-4 mb-4">Silahkan isi alamat Email dan NIK untuk melihat hasil verifikasi</p>
                        @else
                        <div class="row mt-3 p-3">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> {{ session('success') }}.
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Gagal!</strong> {{ session('error') }}.
                                </div>
                            @endif
                            @php
                            try {
                                $formattedDate = \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y');
                            } catch (\Exception $e) {
                                $formattedDate = $peserta->tanggal_lahir;
                            }
                        @endphp
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="">Nama</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->nama}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">NIK</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->nik}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Email</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->email}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Jenis Kelamin</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->jenis_kelamin}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Formasi yang Dilamar</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->formasi}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="">Tempat/Tanggal Lahir</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->tempat_lahir}}/{{ $formattedDate }}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Alamat</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->alamat}}</span>
                                </div>
                            {{-- @if ($peserta->keterangan != 'L') --}}
                                    <div class="col-md-12">
                                        <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-3">
                                            <button type="submit" data-bs-toggle="modal" data-bs-target="#sanggahForm" class="btn btn-primary btn-lg" style="background-color: #DF9755;border-color: #E7D283; border-radius: 0px">
                                                Klik untuk Sanggah
                                            </button>
                                        </div>
                                    </div>
                        
                            {{-- @endif --}}
                        </div>
                        <div class="modal fade" id="sanggahForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Sanggah</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('karir.sanggah', $peserta->id ?? 'anonym')}}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group mb-3">
                                                <div class="alert alert-info" role="alert">
                                                    <strong>Informasi</strong><br>
                                                    Untuk mengantisipasi perubahan penulisan sanggahan, maka Anda hanya dijinkan menulis sanggah sebanyak satu kali. Mohon mencermati kembali hasil pesan Anda
                                                </div>
                                                <small for="">Pesan Sanggahan</small>
                                                @if ($peserta->sanggahan == NULL)
                                                <input type="text" name="sanggah" class="form-control mt-2 mb-3" style="border-radius: 0px"  placeholder="Isi Sanggahan Anda disini" @if ($datetimeNow->greaterThan($deadline)) disabled @endif>
                                                @else
                                                <input type="text" name="sanggah" class="form-control mt-2 mb-3" style="border-radius: 0px" disabled value="{{$peserta->sanggahan}}">
                                                @endif
                                                @if ($datetimeNow->greaterThan($publish_response))
                                                <div class="alert alert-success" role="alert">
                                                    <strong>Balasan Sanggah</strong><br>
                                                    {{$peserta->response_sanggah}}
                                                </div>
                                                @endif
                                            </div>
                                            
                                        @if ($datetimeNow->lessThanOrEqualTo($deadline))
                                            <div class="modal-footer">
                                                @if ($peserta->sanggahan == NULL)
                                                <button type="submit" class="btn btn-success" style="background-color: #EB5A3C;border-color: #E7D283; border-radius: 0px">Sanggah</button>
                                                @endif
                                            </div>
                                        @else
                                            <div class="alert alert-danger" role="alert">
                                                <strong>Informasi!</strong>
                                                <p>Sesuai dengan Pengumuman, Masa Sanggah ditutup pada Hari Kamis Tanggal 20 Maret 2025 Pukul 12.00 WIB</p>
                                            </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </section>
        <footer>
            <div class="container mt-4 text-center">
                <small>Team IT RSUD Brebes 2025</small>
            </div>
        </footer>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="{{ asset('js/apps.js') }}"></script>
    </body>
</html>
