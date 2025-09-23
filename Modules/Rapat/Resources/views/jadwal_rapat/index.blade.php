@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Rapat</li>
        <li class="breadcrumb-item active" aria-current="page">Jadwal Rapat</li>
    </ol>
</nav>
<div class="row profile-body">
    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <form method="GET" action="">
                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                                <label for="" style="margin: 0; white-space: nowrap;">RUANGAN :</label>
                                <select name="id_ruang" class="form-control" style="flex: 1;" onchange="this.form.submit()">
                                    <option value="">–- PILIH RUANG PERTEMUAN –-</option>
                                    @foreach($ruang_rapat as $ruangan)
                                    <option value="{{ $ruangan->id }}" {{ request('id_ruang') == $ruangan->id ? 'selected' : '' }}>
                                        {{ $ruangan->nama }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        @if (request('id_ruang'))
                        @if (auth()->user()->level == 2)
                        <div class="row align-items-center mb-3">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#tambahRapatModal">
                                    <i data-feather="plus"></i> TAMBAH RAPAT
                                </button>
                            </div>
                            <div class="col-md-9">
                                <form action="{{ route('rapat.jadwal_rapat.cari') }}" method="GET">
                                    <input type="hidden" name="id_ruang" value="{{ request('id_ruang') }}">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </div>
                                        <input type="text" name="cari" class="form-control" placeholder="cari nama rapat ..." value="{{ request('cari') }}">
                                        <button type="submit" class="btn btn-secondary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @else
                        <div class="row align-items-center mb-3">
                            <div class="col-12">
                                <form action="{{ route('rapat.jadwal_rapat.cari') }}" method="GET">
                                    <input type="hidden" name="id_ruang" value="{{ request('id_ruang') }}">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </div>
                                        <input type="text" name="cari" class="form-control" placeholder="cari nama rapat ..." value="{{ request('cari') }}">
                                        <button type="submit" class="btn btn-secondary">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive mt-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA RAPAT</th>
                                        <th>HARI, TANGGAL</th>
                                        <th>WAKTU</th>
                                        <th>PESERTA</th>
                                        <th>PESANAN</th>
                                        <th>PIC</th>
                                        <th>STATUS</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jadwal_rapat as $index => $rapat)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $rapat->nama_rapat }}</td>
                                        <td>{{ \Carbon\Carbon::parse($rapat->tanggal)->locale('id')->translatedFormat('l, d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($rapat->jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($rapat->jam_selesai)->format('H:i') }} WIB</td>
                                        <td>{{ $rapat->jumlah_peserta }}</td>
                                        <td><span class="badge bg-primary">{{ $rapat->jumlah_snack }} SNACK</span> - <span class="badge bg-primary">{{ $rapat->jumlah_makan }} MAKAN</span></td>
                                        <td>
                                            {{ $rapat->gelar_depan ? $rapat->gelar_depan . '. ' : '' }}
                                            {{ Str::title(strtolower($rapat->nama)) }}
                                            {{ $rapat->gelar_belakang ? ', ' . $rapat->gelar_belakang : '' }}
                                        </td>
                                        <td>{{ $rapat->status }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($rapat->nip_nipppk_nrpk_nrpblud === Auth::user()->username)
                                                <button class="btn btn-primary btn-xs btn-icon" data-bs-toggle="modal" title="Edit" data-bs-target="#editJadwalRapat{{$rapat->id_rapat}}">
                                                    <i data-feather="edit"></i>
                                                </button>
                                                <a href="{{ route('rapat.kehadiran_rapat.index', ['uuid_jadwal_rapat' => $rapat->uuid]) }}" class="btn btn-default btn-xs btn-icon" data-bs-toggle="tooltip" title="Kehadiran">
                                                    <i data-feather="file-text"></i>
                                                </a>
                                                <form onsubmit="return confirm('Apakah Anda yakin menghapus {{ $rapat->nama_rapat }} ini?');"
                                                    action="{{ route('rapat.jadwal_rapat.destroy', $rapat->id_rapat) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon" data-bs-toggle="tooltip" title="Hapus">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                                @else

                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada jadwal rapat untuk ruangan ini.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $jadwal_rapat->appends(request()->query())->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                        <div class="modal fade" id="tambahRapatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">TAMBAH JADWAL RAPAT</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('rapat.jadwal_rapat.store') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <p class="text-danger">
                                                                <b>AM</b> (Ante Meridiem) berarti "sebelum tengah hari" (00:00–11:59), dan
                                                                <b>PM</b> (Post Meridiem) berarti "setelah tengah hari" (12:00–23:59).<br>
                                                                <b>12:00 AM adalah pukul 00:00 WIB malam</b><br>
                                                                <b>12:00 PM adalah pukul 12:00 WIB siang</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">NAMA RAPAT</label>
                                                            <input type="text" class="form-control" name="nama_rapat" placeholder="masukan nama rapat" style="text-transform: uppercase;" required>
                                                            @error('nama_rapat')
                                                            <code>{{$message}}</code>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">JUMLAH PESERTA</label>
                                                            <input type="number" name="jumlah_peserta" class="form-control" placeholder="0" required>
                                                            @error('jumlah_peserta')
                                                            <code>{{$message}}</code>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">TANGGAL RAPAT</label>
                                                            <input type="date" class="form-control" name="tanggal" required>
                                                            @error('tanggal')
                                                            <code>{{$message}}</code>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">JAM MULAI</label>
                                                            <input type="time" name="jam_mulai" class="form-control" required>
                                                            @error('jam_mulai')
                                                            <code>{{$message}}</code>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">JAM SELESAI</label>
                                                            <input type="time" name="jam_selesai" class="form-control" required>
                                                            @error('jam_selesai')
                                                            <code>{{$message}}</code>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">JUMLAH SNACK</label>
                                                            <input type="number" name="jumlah_snack" class="form-control" placeholder="0" required>
                                                            @error('jumlah_snack')
                                                            <code>{{$message}}</code>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">JUMLAH MAKAN</label>
                                                            <input type="number" name="jumlah_makan" class="form-control" placeholder="0" required>
                                                            @error('jumlah_makan')
                                                            <code>{{$message}}</code>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id_ruang" value="{{ request('id_ruang') }}">
                                                <input type="hidden" name="status" value="terjadwal">
                                                <input type="hidden" name="pic" value="{{ auth()->user()->username }}">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                                                <button type="submit" class="btn btn-success">SIMPAN</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($jadwal_rapat as $rapat)
<div class="modal fade" id="editJadwalRapat{{$rapat->id_rapat}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT JADWAL RAPAT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rapat.jadwal_rapat.update', $rapat->id_rapat) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <p class="text-danger">
                                        <b>AM</b> (Ante Meridiem) berarti "sebelum tengah hari" (00:00–11:59), dan
                                        <b>PM</b> (Post Meridiem) berarti "setelah tengah hari" (12:00–23:59).<br>
                                        <b>12:00 AM adalah pukul 00:00 WIB malam</b><br>
                                        <b>12:00 PM adalah pukul 12:00 WIB siang</b>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="" class="form-label">NAMA RAPAT</label>
                                    <input type="text" class="form-control" name="nama_rapat" placeholder="masukan nama rapat" style="text-transform: uppercase;" value="{{$rapat->nama_rapat}}" required>
                                    @error('nama_rapat')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">JUMLAH PESERTA</label>
                                    <input type="number" name="jumlah_peserta" class="form-control" placeholder="0" value="{{$rapat->jumlah_peserta}}" required>
                                    @error('jumlah_peserta')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">TANGGAL RAPAT</label>
                                    <input type="date" class="form-control" name="tanggal" value="{{$rapat->tanggal}}" required>
                                    @error('tanggal')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">JAM MULAI</label>
                                    <input type="time" name="jam_mulai" class="form-control" value="{{$rapat->jam_mulai}}" required>
                                    @error('jam_mulai')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">JAM SELESAI</label>
                                    <input type="time" name="jam_selesai" class="form-control" value="{{$rapat->jam_selesai}}" required>
                                    @error('jam_selesai')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">JUMLAH SNACK</label>
                                    <input type="number" name="jumlah_snack" class="form-control" placeholder="0" value="{{$rapat->jumlah_snack}}" required>
                                    @error('jumlah_snack')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">JUMLAH MAKAN</label>
                                    <input type="number" name="jumlah_makan" class="form-control" placeholder="0" value="{{$rapat->jumlah_makan}}" required>
                                    @error('jumlah_makan')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">STATUS</label>
                                    <select name="status" class="form-control" required>
                                        @if ($rapat->status == 'terjadwal')
                                        <option value="terjadwal" selected>terjadwal</option>
                                        <option value="dimulai">dimulai</option>
                                        <option value="selesai">selesai</option>
                                        @elseif ($rapat->status == 'dimulai')
                                        <option value="terjadwal">terjadwal</option>
                                        <option value="dimulai" selected>dimulai</option>
                                        <option value="selesai">selesai</option>
                                        @elseif ($rapat->status == 'selesai')
                                        <option value="terjadwal">terjadwal</option>
                                        <option value="dimulai">dimulai</option>
                                        <option value="selesai" selected>selesai</option>
                                        @else
                                        <option value="">Pilih status</option>
                                        <option value="terjadwal">terjadwal</option>
                                        <option value="dimulai">dimulai</option>
                                        <option value="selesai">selesai</option>
                                        @endif
                                    </select>
                                    @error('status')
                                    <code>{{$message}}</code>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">PIC</label>
                                    <input type="text" class="form-control" placeholder="{{ $rapat->gelar_depan }} {{ $rapat->nama }}, {{ $rapat->gelar_belakang }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id_ruang" value="{{$rapat->id_ruang}}">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">BATAL</button>
                        <button type="submit" class="btn btn-success">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
<script src="{{ asset('assets/js/data-table.js') }}"></script>

@endpush