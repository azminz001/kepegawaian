@extends('layout.master2')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="page-content d-flex align-items-center justify-content-center px-3">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-12 col-md-10 col-lg-6 col-xl-4 mx-auto">
            <h4 class="text-center mb-3">FORMULIR KEHADIRAN AGENDA</h4>

            {{-- Flash Message --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- Info Agenda --}}
            <div class="card mb-3">
                <div class="card-body table-responsive">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>Nama Agenda</strong></td>
                            <td>: {{ strtoupper($rapat->nama_rapat) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Hari, Tanggal</strong></td>
                            <td>: {{ \Carbon\Carbon::parse($rapat->tanggal)->translatedFormat('l, d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Pukul</strong></td>
                            <td>: {{ \Carbon\Carbon::parse($rapat->jam_mulai)->format('H:i') }} WIB - {{ \Carbon\Carbon::parse($rapat->jam_selesai)->format('H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat</strong></td>
                            <td>: {{ $rapat->nama }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Form Kehadiran --}}
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="formulirTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pegawai-tab" data-bs-toggle="tab" data-bs-target="#pegawai" type="button" role="tab">
                                Pegawai RSUD Brebes
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="nonpegawai-tab" data-bs-toggle="tab" data-bs-target="#nonpegawai" type="button" role="tab">
                                Bukan Pegawai RSUD Brebes
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="formulirTabsContent">
                        {{-- Tab Pegawai --}}
                        <div class="tab-pane fade show active" id="pegawai" role="tabpanel">
                            <form method="POST" action="{{ route('rapat.kehadiran_rapat.store') }}">
                                @csrf
                                <input type="hidden" name="uuid_jadwal_rapat" value="{{ $rapat->uuid }}">
                                <input type="hidden" name="instansi" value="RSUD Brebes">

                                <div class="mb-3">
                                    <label for="nama_pegawai" class="form-label">Nama Lengkap dan Gelar</label>
                                    <select name="pegawai_id" class="form-control select2" data-width="100%" required>
                                        <option value="">-- PILIH NAMA / NOMOR PEGAWAI ANDA</option>
                                        @foreach ($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}">
                                            {{ $pegawai->gelar_depan ? $pegawai->gelar_depan . '. ' : '' }}
                                            {{ Str::title(strtolower($pegawai->nama)) }}
                                            {{ $pegawai->gelar_belakang ? ', ' . $pegawai->gelar_belakang : '' }}
                                            ({{ $pegawai->nip_nipppk_nrpk_nrpblud }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('pegawai_id')
                                    <code>{{ $message }}</code>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">HADIR</button>
                                </div>
                            </form>
                        </div>

                        {{-- Tab Non Pegawai --}}
                        <div class="tab-pane fade" id="nonpegawai" role="tabpanel">
                            <form method="POST" action="{{ route('rapat.kehadiran_rapat.store') }}">
                                @csrf
                                <input type="hidden" name="uuid_jadwal_rapat" value="{{ $rapat->uuid }}">

                                <div class="mb-3">
                                    <label for="nama_peserta" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_peserta" placeholder="Masukkan nama beserta gelar ..." required>
                                </div>
                                <div class="mb-3">
                                    <label for="nip_nrp" class="form-label">NIP / NRP</label>
                                    <input type="number" class="form-control" name="nip_nrp" placeholder="Masukkan NIP atau NRP ..." required>
                                </div>
                                <div class="mb-4">
                                    <label for="instansi" class="form-label">Asal Instansi / Organisasi</label>
                                    <input type="text" name="instansi" class="form-control" placeholder="Contoh: Dinas Kesehatan, Polres Brebes" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">HADIR</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%' // Memastikan select-nya menyesuaikan lebar
        });
    });
</script>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>