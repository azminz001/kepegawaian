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
                        <span class="d-flex" role="search">
                            <span class="btn btn-outline-info mx-2">{{Auth::user()->name}} </span>
                            <a href="{{route('kepegawaian.logout')}}"><button class="btn btn-danger">Logout</button></a>
                        </span>
                    </div>
                </nav>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="card mt-5">
                    <h5 class="card-header bg-success text-white">Data Sanggahan Berkas Pengumuman Seleksi Administrasi Tahun 2025</h5>
                    <div class="card-body table-responsive">
                        <h4>Belum Response Sanggahan</h4>
                        <div class="mb-3">
                            <form action="{{ route('karir.filter_formasi') }}">
                                <label for="exampleFormControlInput1" class="form-label">Filter Formasi</label>
                                <select name="formasi" id="" class="form-control">
                                    <option disabled selected value="">- Pilih Formasi-</option>
                                    <option value="Tenaga Teknis Kefarmasian">Tenaga Teknis Kefarmasian</option>
                                    <option value="Pranata Laboratorium Kesehatan">Pranata Laboratorium Kesehatan</option>
                                    <option value="Perekam Medik">Perekam Medik</option>
                                    <option value="Perawat Umum">Perawat Umum</option>
                                    <option value="Perawat Hemodialisa">Perawat Hemodialisa</option>
                                    <option value="Perawat Bangsal Jantung / Cathlab">Perawat Bangsal Jantung / Cathlab</option>
                                    <option value="Penata Anestesi/Asisten Penata Anestesi">Penata Anestesi/Asisten Penata Anestesi</option>
                                    <option value="Okupasi Terapi">Okupasi Terapi</option>
                                    <option value="Fisioterapis">Fisioterapis</option>
                                    <option value="Apoteker">Apoteker</option>
                                    <option value="Pranata Komputer (Web Developer)">Pranata Komputer (Web Developer)</option>
                                    <option value="Pranata Komputer (Mobile Developer)">Pranata Komputer (Mobile Developer)</option>
                                    <option value="Pranata Komputer (IT Support)">Pranata Komputer (IT Support)</option>
                                </select>
                                <button class="btn btn-success btn-sm mt-3" type="submit">Filter Formasi</button>
                            </form>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Formasi</th>
                                    <th>Sanggah</th>
                                    <th>Balasan</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peserta as $key => $p)
                                <tr>
                                    <td scope="row">{{ $key + $peserta->firstItem() }}</td>
                                    <td>{{$p->nama}}<br /><small>NIK. {{$p->nik}}</small></td>
                                    <td>{{$p->formasi}}</td>
                                    <td><small>{{$p->sanggahan}}</small></td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-id="{{$p->id}}" data-bs-toggle="modal" data-bs-target="#tanggapi">Tanggapi</button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td>Belum ada sanggahan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $peserta->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                        </div>
                        <h4 class="mt-5">Sudah Response Sanggahan</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Formasi</th>
                                    <th>Sanggahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($peserta_response as $key => $p)
                                <tr>
                                    <td scope="row">{{ $key + 1 }}</td>
                                    <td>{{$p->nama}}<br /><small>NIK. {{$p->nik}}</small><br/><button class="btn btn-sm btn-primary" data-id="{{$p->id}}" data-bs-toggle="modal" data-bs-target="#tanggapi">Ubah Tanggapan</button></td>
                                    <td>{{$p->formasi}}</td>
                                    <td><small>{{$p->sanggahan}}<br /><b>Balasan:</b> [{{$p->verifikator_response}}]<br>{{$p->response_sanggah}}</small></td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Belum ada sanggahan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="tanggapi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-focus="false">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Form Tanggapi Sanggahan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                        </div>
                        <form id="editSanggahanForm" method="post">
                            @csrf
                            @method('PUT')
                            
                            <div class="modal-body">
                                <div class="container"><div class="row">
                                    <input type="hidden" name="verifikator_response" value="{{Auth::user()->name}}">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama" id="nama" disabled>
                                            @error('nama')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" id="email" disabled>
                                            @error('email')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">NIK</label>
                                            <input type="text" class="form-control" name="nik" id="nik" disabled>
                                            @error('nik')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Formasi</label>
                                            <input type="text" class="form-control" name="formasi" id="formasi" disabled>
                                            @error('formasi')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jenis Kelamin</label>
                                            <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" disabled>
                                            @error('jenis_kelamin')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Jenjang</label>
                                            <input type="text" class="form-control" name="jenjang" id="jenjang" disabled>
                                            @error('nik')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Catatan</label>
                                            <textarea class="form-control" name="catatan" id="catatan" disabled></textarea>
                                            @error('catatan')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Sanggahan</label>
                                            <textarea class="form-control" name="sanggahan" id="sanggahan" disabled></textarea>
                                            @error('catatan')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Tanggapi Sanggahan</label>
                                            <textarea class="form-control" name="response_sanggah" id="response_sanggah"></textarea>
                                            @error('catatan')
                                                <code>{{$message}}</code>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <button type="submit" class="btn btn-success me-2">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container mt-4 text-center">
                <small>Team IT RSUD Brebes 2025</small>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var baseUrl = '{{ url('/') }}';
                $('#tanggapi').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var pesertaId = button.data('id');
                    var url = baseUrl + '/karir/data_sanggahan/edit/' + pesertaId;
                    $.ajax({
                        url: url,
                        method: 'GET',
                        success: function(data) {
                            $('#nama').val(data.nama);
                            $('#email').val(data.email);
                            $('#nik').val(data.nik);
                            $('#formasi').val(data.formasi);
                            $('#jenis_kelamin').val(data.jenis_kelamin);
                            $('#jenjang').val(data.jenjang);
                            $('#catatan').val(data.verifikator+'-'+data.catatan);
                            $('#sanggahan').val(data.sanggahan);
                            $('#response_sanggah').val(data.response_sanggah);
                            var formAction = "{{ route('karir.tanggapi_sanggahan', ':id') }}";
                            formAction = formAction.replace(':id', data.id);
                            $('#editSanggahanForm').attr('action', formAction);
                            },
                        error: function() {
                            alert('Gagal mengambil data');
                        }
                    });
                });
            });
        </script>
    </body>
</html>

