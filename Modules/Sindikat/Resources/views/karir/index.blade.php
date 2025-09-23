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
            <div class="container">
                <div class="card mt-3">
                    <h5 class="card-header text-white p-3" style="background-color:  #EB5A3C;border-radius: 0px">Validasi Berkas Pengumuman Seleksi Administrasi Tahun 2025</h5>
                    <div class="card-body" style="background-color:#F5F5F5">
                        <h4 class="card-text text-center mt-3 mb-4">Input Email dan NIK dengan benar.</h4>
                        <form action="{{ route('karir.filter') }}">
                            <div class="row p-4">
                                <div class="col-md-6 col-sm-12 mb-4">
                                    <div class="form-group">
                                        <input type="text"class="form-control form-control-lg" name="email" id="" aria-describedby="helpId" placeholder="Input Email Anda" style="border-radius: 0px">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 mb-4">
                                    <div class="form-group">
                                        <input type="text"class="form-control form-control-lg" name="nik" id="" aria-describedby="helpId" placeholder="Input NIK Anda" style="border-radius: 0px">
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
                            <p class="text-danger text-center mt-4 mb-4">Alamat Email atau NIK yang Anda daftarkan tidak cocok, Pastikan Alamat email dan NIK sesuai dengan data ketika melamar.<br /> Anda dinyatakan lolos tetapi tidak bisa akses data, silahkan hubungi 085xxxxxxxx</p>
                        @elseif ($peserta == "2")
                            <p class="text-center mt-4 mb-4">Bagi Anda yang sudah lolos silahkan isi alamat Email dan NIK untuk mendapatkan Nomor Peserta</p>
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
                                    <label for="">Nomor Peserta</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->no_peserta}}</span>
                                </div>
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
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="">Formasi yang Dilamar</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->formasi}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Jenjang Pendidikan</label>
                                    <span class="form-control" style="border-radius: 0px">{{ $peserta->jenjang }}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Tempat/Tanggal Lahir</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->tempat_lahir}}/{{ $formattedDate }}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="">Alamat</label>
                                    <span class="form-control" style="border-radius: 0px">{{$peserta->alamat}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if ($peserta->foto == null)
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    <strong>Informasi</strong> 
                                    <p>Untuk mencetak Kartu Peserta Ujian Seleksi Tenaga BLUD RSUD Brebes, mohon untuk upload foto terlebih dahulu.</p>
                                </div>
                                @else
                                <img src="{{url('/storage/foto_peserta_karir/'.$peserta->foto)}}?t={{ time() }}" width="250px" alt="" srcset=""> <br>
                                @endif
                                <button class="btn btn-success mt-1" data-bs-toggle="modal" style="background-color: #EB5A3C;border-color: #E7D283; border-radius: 0px" data-bs-target="#editFoto">{{$peserta->foto == null ? 'Upload':'Ganti'}} Foto</button>
                            </div>
                            @if ($peserta->foto != null)
                            <div class="col-md-12">
                                <div class="d-grid gap-2 col-6 mx-auto mt-3 mb-3">
                                    <button data-bs-toggle="modal" data-bs-target="#print" class="btn btn-success btn-lg" style="background-color: #DF9755;border-color: #E7D283; border-radius: 0px">Cetak Kartu Peserta</button>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div class="container mt-4 text-center">
                <small>Team IT RSUD Brebes 2025</small>
            </div>
        </footer>
        @if ($peserta != "2" )
        <div class="modal fade" id="print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Preview Kartu Peserta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="printKartu">
                        <div>
                            <h6 class="text-center">Kartu Peserta Ujian Seleksi Tenaga BLUD RSUD Brebes</h6>
                            <hr>
                            @if ($peserta == "1")
                            <p class="text-danger text-center mt-4 mb-4">Alamat Email atau NIK yang Anda daftarkan tidak cocok, Pastikan Alamat email dan NIK sesuai dengan data ketika melamar.</p>
                            @elseif ($peserta == "2")
                                <p class="text-center mt-4 mb-4">Bagi Anda yang sudah lolos silahkan isi alamat Email dan NIK untuk mendapatkan Nomor Peserta</p>
                            @else
                            <div class="d-flex justify-content-between">
                                <div class="text-center" class="" id="qrcode"></div>
                                <img src="{{url('/storage/foto_peserta_karir/'.$peserta->foto)}}?t={{ time() }}" height="120" alt="" srcset="">
                            </div>
                            <label for="" class="mt-2"><strong>Informasi Peserta</strong></label>
                            <div class="form-group mb-1">
                                <small for="">Nomor Peserta</small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->no_peserta}}</span>
                            </div>
                            <div class="form-group mb-1">
                                <small for="">No. Identitas KTP</small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->nik}}</span>
                            </div>
                            <div class="form-group mb-1">
                                <small for="">Nama</small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->nama}}</span>
                            </div>
                            <div class="form-group mb-1">
                                <small for="">Tempat / Tanggal Lahir </small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->tempat_lahir}} / {{ $formattedDate }}</span>
                            </div>
                            <div class="form-group mb-1">
                                <small for="">Jenis Kelamin</small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->jenis_kelamin}}</span>
                            </div>
                            <div class="form-group mb-1">
                                <small for="">Formasi</small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->formasi}}</span>
                            </div>
                            <div class="form-group mb-1">
                                <label for="">Jenjang Pendidikan</label>
                                <span class="form-control form-control-sm" style="border-color: black">{{ $peserta->jenjang }}</span>
                            </div>
                            <label for="" class="mt-2"><strong>Informasi Ujian</strong></label>
                            <div class="form-group mb-1">
                                <small for="">Tempat</small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->tempat_ujian}}</span>
                            </div>
                            <div class="form-group mb-1">
                                <small for="">Tanggal</small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->tanggal_ujian}}</span>
                            </div>
                            <div class="form-group mb-1">
                                <small for="">Sesi</small>
                                <span class="form-control form-control-sm" style="border-color: black">{{$peserta->sesi_ujian}}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="printDiv('printKartu')">Cetak Kartu</button>
                        <button type="button" class="btn btn-danger" onclick="downloadPDF()">Download Kartu</button>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="modal fade" id="editFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Foto Peserta Ujian</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{route('karir.update', $peserta->id ?? 'anonym')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <small for="">Pilih Foto</small>
                                <input type="file" name="foto" class="form-control" id="" accept="image/*" style="border-radius: 0px">
                            </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" style="background-color: #EB5A3C;border-color: #E7D283; border-radius: 0px">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="{{ asset('js/apps.js') }}"></script>
        <script>
            const qrcode = new QRCode(document.getElementById('qrcode'), {
                text: 'https://sim.rsudbrebes.id/karir/verify/{{$peserta->nik ?? "none"}}',
                width: 120,
                height: 120,
                colorDark : '#000',
                colorLight : '#fff',
                correctLevel : QRCode.CorrectLevel.H
            });
        </script>
    </body>
</html>
