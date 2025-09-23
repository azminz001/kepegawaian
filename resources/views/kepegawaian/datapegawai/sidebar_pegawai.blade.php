@if (Auth::user()->level == 0 || Auth::user()->level == 1)
<div class="col-12 mb-4">
    <div class="list-group">
        <a href="{{route('data_pegawai.show', $pegawai->id)}}" class="list-group-item list-group-item-action btn-icon-text {{ request()->routeIs('data_pegawai.show') ? 'active' : '' }}"><i class="btn-icon-prepend icon-sm mx-2" data-feather="user"></i> Biodata Diri</a>
        <a href="{{route('data_pegawai.riwayat_jabatan', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_jabatan') ? 'active' : '' }}"><i class="btn-icon-prepend icon-sm mx-2" data-feather="briefcase"></i> Riwayat Jabatan Pegawai</a>
        <a href="{{route('data_pegawai.riwayat_jabatan_unit', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_jabatan_unit') ? 'active' : '' }}"><i class="mdi mdi-hospital-building mx-2"></i> Riwayat Jabatan Unit</a>
        @if ($pegawai->status_kepegawaian == 'PNS' || $pegawai->status_kepegawaian == 'PPPK')
        <a href="{{route('data_pegawai.riwayat_golongan', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_golongan') ? 'active' : '' }}"><i class="mdi mdi-account-box-outline mx-2"></i> Riwayat Golongan</a>
        <a href="{{route('data_pegawai.riwayat_gaji_berkala', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_gaji_berkala') ? 'active' : '' }}"><i class="mdi mdi-cash-multiple mx-2"></i> Riwayat Gaji Berkala</a>
        @endif
        <a href="{{route('data_pegawai.riwayat_pendidikan', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_pendidikan') ? 'active' : '' }}"><i class="mdi mdi-school mx-2"></i> Riwayat Pendidikan</a>
        <a href="{{route('data_pegawai.riwayat_diklat', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_diklat') ? 'active' : '' }}"><i class="mdi mdi-certificate mx-2"></i> Riwayat Diklat</a>
        <a href="{{route('data_pegawai.riwayat_karya_ilmiah', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_karya_ilmiah') ? 'active' : '' }}"><i class="mdi mdi-chemical-weapon mx-2"></i> Riwayat Karya Ilmiah</a>
        <a href="{{route('data_pegawai.riwayat_pekerjaan', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_pekerjaan') ? 'active' : '' }}"><i class="mdi mdi-account-box-outline mx-2"></i> Riwayat Pekerjaan </a>
        <a href="{{route('data_pegawai.riwayat_organisasi', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.organisasi') ? 'active' : '' }}"><i class="mdi mdi-google-circles-extended mx-2"></i> Riwayat Organisasi </a>
        <a href="{{route('data_pegawai.riwayat_pegawai_ci', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.riwayat_pegawai_ci') ? 'active' : '' }}"><i class="mdi mdi-account-network mx-2"></i> Riwayat Instruktur Klinik </a>
        <a href="{{route('data_pegawai.pasangan', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.pasangan') ? 'active' : '' }}"><i class="mdi mdi-human-male-female mx-2"></i> Data Suami/Istri</a>
        <a href="{{route('data_pegawai.anak', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.anak') ? 'active' : '' }}"><i class="mdi mdi-human-child mx-2"></i> Data Anak</a>
        @if ($pegawai->status_kepegawaian == 'BLUD' || $pegawai->status_kepegawaian == 'MITRA' || $pegawai->status_kepegawaian == 'KONTRAK')
        <a href="{{route('data_pegawai.permohonan_kontrak', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.permohonan_kontrak') ? 'active' : '' }}"><i class="mdi mdi-file-plus mx-2"></i> Permohonan Kontrak Kerja</a>
        @endif
        <a href="{{route('data_pegawai.dokumen', $pegawai->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('data_pegawai.dokumen') ? 'active' : '' }}"><i class="mdi mdi-file-document mx-2"></i> Dokumen Pegawai</a>
        {{-- <a href="#" onclick="alert('cooming soon...')" class="list-group-item list-group-item-action {{ request()->routeIs() ? 'active' : '' }}"><i class="mdi mdi mdi-trending-up mx-2"></i> Evaluasi Kinerja Pegawai</a> --}}
    </div>
</div>
@endif
<div class="col-12">
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
        Status Pegawai
        <?php
            $status = "";
            $color = "";
            if($pegawai->status_pegawai == 0){
                $color = "success";
                $status = "AKTIF";
            }elseif ($pegawai->status_pegawai == 1) {
                $color = "danger";
                $status = "TIDAK AKTIF";
            }elseif ($pegawai->status_pegawai == 2) {
                $color = "info";
                $status = "MUTASI";
            }elseif ($pegawai->status_pegawai == 3) {
                $color = "primary";
                $status = "PENSIUN";
            }elseif ($pegawai->status_pegawai == 4) {
                $color = "danger";
                $status = "DIBERHENTIKAN";
            }
        ?>
        <span class="badge rounded-pill bg-{{$color}}">{{$status}}</span>
        </li>
        @if ($pegawai->status_pegawai != 1)
        <li class="list-group-item d-flex justify-content-between align-items-center">
        Masa Kerja RSUD
        <span class="badge bg-success rounded-pill">

            @php
                if ($pegawai->tmt_rsud != null) {
                        $tmt = new DateTime($pegawai->tmt_rsud);
                    } else {
                        $tmt = new DateTime();
                    }
                $now = new DateTime();
                $masa_kerja  = $tmt->diff($now);
            @endphp
            {{$masa_kerja->y." tahun ".$masa_kerja->m." bulan ".$masa_kerja->d." hari"}}
        </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
        Usia
        <span class="badge bg-primary rounded-pill">
            <?php
                $tanggal_1  = new DateTime($pegawai->tanggal_lahir);
                $tanggal_2 = new DateTime();
                $usia  = $tanggal_1->diff($tanggal_2);
            ?>
            {{$usia->y." tahun ".$usia->m." bulan ".$usia->d." hari"}}
        </span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
        Perkiraan Pensiun
        <span class="badge bg-danger rounded-pill">
            <?php
                $tahun_lahir = date('Y', strtotime($pegawai->tanggal_lahir));
            ?>
            {{$tahun_lahir + 58}} / {{$tahun_lahir + 60}}
        </span>
        </li>
        @elseif($pegawai->status_pegawai == 1 && Auth::user()->level == 2)
        <div class="alert alert-danger mt-2" role="alert">
            <h5><i data-feather="alert-circle"></i> Pemberitahuan</h5>
            <p class="mt-2">Saat ini status kepegawaian Anda <span class="badge bg-danger rounded-pill">BELUM AKTIF</span>, Hubungi Kepegawaian untuk mengaktifkan dan lengkapi administrasi kepegawaian Anda.</p>
        </div>
        @endif
    </ul>
</div>
<div class="col-12 mt-4">
    <div class="card rounded">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h6 class="card-title mb-0">MOTTO</h6>
            </div>
            <p>{{$pegawai->motto}}</p>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Unit Kerja</label>
                <p class="text-muted">{{(isset($pegawai->unit_jabatan_aktif->nama_unit)) ? $pegawai->unit_jabatan_aktif->nama_unit : "Belum mengatur unit kerja"}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Jabatan Unit:</label>
                <p class="text-muted">{{isset($pegawai->unit_jabatan_aktif->nama_jabatan_unit) ? $pegawai->unit_jabatan_aktif->nama_jabatan_unit : "Belum mengatur jabatan di unit kerja"}}</p>
            </div>
            <div class="mt-3">
                <label class="tx-11 fw-bolder mb-0 text-uppercase">Jabatan Pegawai:</label>
                <p class="text-muted">{{isset($pegawai->jabatan_aktif->nama_jabatan) ? $pegawai->jabatan_aktif->nama_jabatan : "Belum mengatur jabatan pegawai"}}</p>
            </div>
        </div>
    </div>
</div>