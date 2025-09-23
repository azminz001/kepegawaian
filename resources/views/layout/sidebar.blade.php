<style>
    .blinking-circle {
        /* Tambahkan ukuran dan posisi sesuai kebutuhan */
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: rgb(255, 29, 29);
        color: white;
        display: inline-block;
        animation: blink-animation 2s infinite;
    }

    @keyframes blink-animation {
        0% {
            background-color: rgb(255, 29, 29);
        }

        50% {
            background-color: rgb(183, 183, 183);
        }

        100% {
            background-color: rgb(255, 29, 29);
        }
    }
</style>
<nav class="sidebar sidebar-dark">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            @if (request()->routeIs('sindikat.*'))
            SIN<span>DIKAT</span>
            @else
            SIM-<span>RSUD</span>
            @endif
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            @if (Auth::user()->level == 0 || Auth::user()->level == 1 || Auth::user()->level == 2)
            <li class="nav-item {{ request()->routeIs('kepegawaian.dashboard') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            @endif

            @if (Auth::user()->level == 2)
            @if (isset($menu_pegawai) && $menu_pegawai->status_pegawai != 1)

            <li class="nav-item nav-category">PEGAWAI</li>

            <li li
                class="nav-item {{ request()->routeIs('data_pegawai.profil') || request()->routeIs('data_pegawai.pasangan') || request()->routeIs('data_pegawai.anak') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse" href="#advanced-ui"
                    role="button" aria-expanded="{{ is_active_route(['advanced-ui/*']) }}"
                    aria-controls="advanced-ui">
                    <i class="link-icon" data-feather="user-check"></i>
                    <span class="link-title">Data Diri</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->routeIs('data_pegawai.profil') || request()->routeIs('data_pegawai.pasangan') || request()->routeIs('data_pegawai.anak') ? 'active show' : '' }}"
                    id="advanced-ui">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/kepegawaian/pegawai/profil') }}"
                                class="nav-link {{ request()->routeIs('data_pegawai.profil') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Biodata Diri</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data_pegawai.pasangan', $menu_pegawai->id) }}"
                                class="nav-link {{ request()->routeIs('data_pegawai.pasangan') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Suami/Istri</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data_pegawai.anak', $menu_pegawai->id) }}"
                                class="nav-link {{ request()->routeIs('data_pegawai.anak') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Anak</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data_pegawai.dokumen', $menu_pegawai->id) }}"
                                class="nav-link {{ request()->routeIs('data_pegawai.dokumen') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Dokumen</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_jabatan') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_jabatan', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Riwayat Jabatan Pegawai</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_jabatan_unit') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_jabatan_unit', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="user-check"></i>
                    <span class="link-title">Riwayat Jabatan Unit</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_pendidikan') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_pendidikan', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="pen-tool"></i>
                    <span class="link-title">Riwayat Pendidikan</span>
                </a>
            </li>

            @if ($menu_pegawai->status_kepegawaian == 'PNS' || $menu_pegawai->status_kepegawaian == 'PPPK')
            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_golongan') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_golongan', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="list"></i>
                    <span class="link-title">Riwayat Golongan</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_gaji_berkala') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_gaji_berkala', $menu_pegawai->id) }}"
                    class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Riwayat Gaji Berkala</span>
                </a>
            </li>
            @endif

            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_diklat') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_diklat', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="award"></i>
                    <span class="link-title">Riwayat Diklat</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_karya_ilmiah') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_karya_ilmiah', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-chemical-weapon"></i>
                    <span class="link-title">Riwayat Karya Ilmiah</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_pekerjaan') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_pekerjaan', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-account-box-outline"></i>
                    <span class="link-title">Riwayat Pekerjaan</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_organisasi') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_organisasi', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-google-circles-extended"></i>
                    <span class="link-title">Riwayat Organisasi</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_pegawai_ci') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.riwayat_pegawai_ci', $menu_pegawai->id) }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-account-network"></i>
                    <span class="link-title">Riwayat Instruktur Klinik</span>
                </a>
            </li>
            @if (
            $menu_pegawai->status_kepegawaian == 'BLUD' ||
            $menu_pegawai->status_kepegawaian == 'MITRA' ||
            $menu_pegawai->status_kepegawaian == 'KONTRAK')
            <li class="nav-item {{ request()->routeIs('data_pegawai.permohonan_kontrak') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('data_pegawai.permohonan_kontrak', $menu_pegawai->id) }}"
                    class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-file-plus"></i>
                    <span class="link-title">Permohonan Kontrak Kerja</span>
                </a>
            </li>
            @endif
            <li class="nav-item {{ request()->is('rapat/jadwal_rapat*') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ url('/rapat/jadwal_rapat') }}"
                    class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-calendar"></i>
                    <span class="link-title">Jadwal Rapat</span>
                </a>
            </li>
            {{-- <li class="nav-item">
          <a href="#" onclick="alert('cooming soon...')"  class="nav-link" style="color: #dbdbdb;">
            <i class="link-icon mdi mdi-trending-up"></i>
            <span class="link-title">Evaluasi Kinerja Pegawai</span>
          </a>
        </li> --}}
            <li class="nav-item nav-category">FASILITAS</li>
            <li class="nav-item">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse" href="#uiComponents"
                    role="button" aria-expanded="{{ is_active_route(['unit/*']) }}"
                    aria-controls="uiComponents">
                    <i class="link-icon mdi mdi-podcast"></i>
                    <span class="link-title">SINDIKAT</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="uiComponents">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/permohonan_diklat') }}" class="nav-link"
                                style="color: #dbdbdb;">Permohonan Diklat</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/peserta_didik') }}"
                                class="nav-link {{ request()->routeIs('jabatan_unit.index') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Evaluasi Peserta Magang</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ url('/persuratan/nomor') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-email-open"></i>
                    <span class="link-title">Permohonan Nomor Surat</span>
                </a>
            </li>
            <li class="nav-item nav-item {{ request()->routeIs('persuratan.buat_suket') ? 'active' : '' }}">
                <a href="{{ route('persuratan.buat_suket.index') }}" class="nav-link"
                    style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Buat SUKET</span>
                </a>
            </li>

            @endif
            @endif

            @if (Auth::user()->level == 0 || Auth::user()->level == 1)
            <li class="nav-item nav-category">KEPEGAWAIAN</li>
            <li class="nav-item {{ request()->routeIs('unit.index') || request()->routeIs('jabatan_unit.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse" href="#uiComponents"
                    role="button" aria-expanded="{{ is_active_route(['unit/*']) }}"
                    aria-controls="uiComponents">
                    <i class="link-icon mdi mdi-hospital-building"></i>
                    <span class="link-title">Data Unit</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->routeIs('unit.index') || request()->routeIs('jabatan_unit.index') ? 'active show' : '' }}"
                    id="uiComponents">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/kepegawaian/unit') }}"
                                class="nav-link {{ request()->routeIs('unit.index') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Unit / Bagian</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/kepegawaian/jabatan_unit') }}"
                                class="nav-link {{ request()->routeIs('jabatan_unit.index') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Jabatan Unit</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ request()->routeIs('kelompok_jabatan.index') || request()->routeIs('jabatan.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse" href="#email"
                    role="button" aria-expanded="{{ is_active_route(['jabatan/*']) }}" aria-controls="email">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Data Jabatan</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse  {{ request()->routeIs('kelompok_jabatan.index') || request()->routeIs('jabatan.index') ? 'active show' : '' }}"
                    id="email">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/kepegawaian/kelompok_jabatan') }}"
                                class="nav-link {{ request()->routeIs('kelompok_jabatan.index') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Kelompok Jabatan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/kepegawaian/jabatan') }}"
                                class="nav-link {{ request()->routeIs('jabatan.index') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Jabatan Pegawai</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ request()->routeIs('data_pegawai.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ url('/kepegawaian/data_pegawai') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Data Pegawai</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('pengguna.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ url('/kepegawaian/pengguna') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Data Pengguna</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('whatsapp.broadcast') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('whatsapp.broadcast') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-whatsapp"></i>
                    <span class="link-title">WA Broadcast</span>
                </a>
            </li>
            <li class="nav-item{{ request()->routeIs('master_ruangan.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse" href="#rapat"
                    role="button" aria-expanded="{{ is_active_route(['master_ruangan/*']) }}" aria-controls="rapat">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Rapat</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse{{ request()->routeIs('master_ruangan.index') ? 'active show' : '' }}"
                    id="rapat">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/rapat/master_ruangan') }}"
                                class="nav-link{{ request()->routeIs('master_ruangan.index') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Master Ruangan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/rapat/jadwal_rapat') }}"
                                class="nav-link{{ request()->routeIs('jadwal_rapat.index') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Jadwal Rapat</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if (Auth::user()->level == 0 || Auth::user()->level == 1 || Auth::user()->level == 3)
            <li class="nav-item nav-category">PERSURATAN</li>

            <li class="nav-item {{ active_class(['apps/chat']) }}">
                <a href="{{ route('persuratan.klasifikasi.index') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Data Klasifikasi</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['apps/chat']) }}">
                <a href="{{ route('persuratan.nomor.index') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="hash"></i>
                    <span class="link-title">Nomor Surat</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['apps/chat']) }}">
                <a href="{{ route('persuratan.surat_masuk.index') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="inbox"></i>
                    <span class="link-title">Surat Masuk</span>
                </a>
            </li>
            <li
                class="nav-item {{ request()->routeIs('persuratan.surat_keterangan.*') || request()->routeIs('persuratan.buat_suket.*') ? 'active' : '' }}">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse" href="#suket"
                    role="button"
                    aria-expanded="{{ request()->routeIs('persuratan.surat_keterangan.*') || request()->routeIs('persuratan.buat_suket.*') ? 'true' : 'false' }}"
                    aria-controls="suket">
                    <i class="link-icon mdi mdi-hospital-building"></i>
                    <span class="link-title">Surat Keterangan</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse {{ request()->routeIs('persuratan.surat_keterangan.*') || request()->routeIs('persuratan.buat_suket.*') ? 'show' : '' }}"
                    id="suket">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('persuratan.surat_keterangan.index') }}"
                                class="nav-link {{ request()->routeIs('persuratan.surat_keterangan.*') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Master SUKET</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('persuratan.buat_suket.index') }}"
                                class="nav-link {{ request()->routeIs('persuratan.buat_suket.*') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Pengajuan SUKET</a>
                        </li>
                    </ul>
                </div>
            </li>
            @if(Auth::user()->level == 3)
            <li class="nav-item {{ request()->routeIs('jadwal_rapat.index') ? 'active' : '' }}">
                <a href="{{ route('rapat.jadwal_rapat.index') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Jadwal Rapat</span>
                </a>
            </li>
            @endif
            @endif


            @if (Auth::user()->level == 0 || Auth::user()->level == 4)
            <!-- level-user 5 untuk admin Sindikat -->

            <li class="nav-item nav-category">SINDIKAT</li>

            <li class="nav-item {{ request()->routeIs('sindikat.kategori.*') || request()->routeIs('sindikat.arsip.*') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse" href="#berita_sindikat"
                    role="button" aria-expanded="{{ is_active_route(['berita_sindikat/*']) }}"
                    aria-controls="berita_sindikat">
                    <i class="link-icon mdi mdi-file"></i>
                    <span class="link-title">Informasi Umum</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->routeIs('sindikat.kategori.*') || request()->routeIs('sindikat.arsip.*') ? 'active show' : '' }}"
                    id="berita_sindikat">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/kategori') }}"
                                class="nav-link {{ request()->routeIs('sindikat.kategori.index') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Kategori</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/arsip/create') }}"
                                class="nav-link {{ request()->routeIs('sindikat.arsip.create') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Buat Arsip Baru</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/arsip/jenis/materi') }}"
                                class="nav-link {{ active_class(['advanced-ui/cropper']) }}"
                                style="color: #dbdbdb;">Arsip Materi</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/arsip/jenis/dokumentasi') }}"
                                class="nav-link {{ active_class(['advanced-ui/owl-carousel']) }}"
                                style="color: #dbdbdb;">Arsip Dokumentasi</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ request()->routeIs('sindikat.permohonan_diklat.*') || request()->routeIs('sindikat.permohonan_magang.*') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse"
                    href="#permohonan_sindikat" role="button"
                    aria-expanded="{{ is_active_route(['permohonan_sindikat/*']) }}"
                    aria-controls="permohonan_sindikat">
                    <i class="link-icon mdi mdi-file-check"></i>
                    <span class="link-title">Data Permohonan</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->routeIs('sindikat.permohonan_diklat.*') || request()->routeIs('sindikat.permohonan_magang.*') ? 'active show' : '' }}"
                    id="permohonan_sindikat">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/permohonan_diklat') }}"
                                class="nav-link {{ request()->routeIs('sindikat.permohonan_diklat.*') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Diklat Pegawai</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/permohonan_magang') }}"
                                class="nav-link {{ request()->routeIs('sindikat.permohonan_magang.*') ? 'active' : '' }}"
                                style="color: #dbdbdb;">PKL/Magang</a>
                        </li>
                        <li class="nav-item">
                            <a href="" onclick="alert('under development')"
                                class="nav-link {{ active_class(['advanced-ui/cropper']) }}"
                                style="color: #dbdbdb;">Studi Banding</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/permohonan_litbang') }}"
                                class="nav-link {{ request()->routeIs('sindikat.permohonan_litbang.*') ? 'active' : '' }}"
                                style="color: #dbdbdb;">Litbang</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ request()->routeIs('sindikat.jenjang.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ url('/sindikat/jenjang') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-chart-line"></i>
                    <span class="link-title">Jenjang</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('sindikat.pegawai.*') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ url('/sindikat/instruktur') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-account-multiple"></i>
                    <span class="link-title">Data Instruktur Klinik</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('sindikat.institusi.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ url('/sindikat/institusi') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-office-building"></i>
                    <span class="link-title">Data Institusi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color: #dbdbdb;" data-bs-toggle="collapse" href="#arsip_sindikat"
                    role="button" aria-expanded="{{ is_active_route(['arsip_sindikat/*']) }}"
                    aria-controls="arsip_sindikat">
                    <i class="link-icon mdi mdi-archive"></i>
                    <span class="link-title">Arsip Berkas Internal</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ is_active_route(['arsip_sindikat/*']) }}" id="arsip_sindikat">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('/sindikat/arsip_diklat') }}"
                                class="nav-link {{ active_class(['advanced-ui/cropper']) }}">Diklat</a>
                        </li>
                        <li class="nav-item">
                            <a href="" onclick="alert('under development')"
                                class="nav-link {{ active_class(['advanced-ui/cropper']) }}">Studi Banding</a>
                        </li>
                        <li class="nav-item">
                            <a href="" onclick="alert('under development')"
                                class="nav-link {{ active_class(['advanced-ui/cropper']) }}">Litbang</a>
                        </li>
                        <li class="nav-item">
                            <a href="" onclick="alert('under development')"
                                class="nav-link {{ active_class(['advanced-ui/owl-carousel']) }}">In House
                                Training</a>
                        </li>
                        <li class="nav-item">
                            <a href="" onclick="alert('under development')"
                                class="nav-link {{ active_class(['advanced-ui/owl-carousel']) }}">Kerjasama/MoU</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item {{ request()->routeIs('sindikat.institusi.pengguna') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ url('/sindikat/institusi/pengguna') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">Data Pengguna</span>
                </a>
            </li>
            @endif

            @if (Auth::user()->level == 0)
            <li class="nav-item nav-category">WhatsApp API</li>

            <li class="nav-item {{ request()->routeIs('whatsappapi.device.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('whatsappapi.device.index') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-cellphone-link"></i>
                    <span class="link-title">Perangkat</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('whatsappapi.log.index') ? 'active' : '' }}"
                style="color: #dbdbdb;">
                <a href="{{ route('whatsappapi.log.index') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon mdi mdi-whatsapp"></i>
                    <span class="link-title">Log WhatsApp</span>
                </a>
            </li>
            @endif
            <li class="nav-item {{ request()->routeIs('data_pegawai.keluhan.*') ? 'active' : '' }} mt-3">
                <a href="{{ route('data_pegawai.keluhan') }}" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon blinking-circle" data-feather="alert-circle"></i>
                    <span class="link-title">Laporkan Kendala</span>
                </a>
            </li>


            {{-- <li class="nav-item nav-category">PORTAL</li>
      <li class="nav-item {{ active_class(['apps/chat']) }}">
            <a href="" onclick="alert('cooming soon...')" class="nav-link" style="color: #dbdbdb;">
                <i class="link-icon" data-feather="aperture"></i>
                <span class="link-title">Rekap Kehadiran</span>
            </a>
            </li>
            <li class="nav-item {{ active_class(['apps/chat']) }}">
                <a href="" onclick="alert('cooming soon...')" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="aperture"></i>
                    <span class="link-title">E-Kinerja</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['apps/chat']) }}">
                <a href="" onclick="alert('cooming soon...')" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="aperture"></i>
                    <span class="link-title">Hukuman Disiplin</span>
                </a>
            </li>
            <li class="nav-item {{ active_class(['apps/chat']) }}">
                <a href="" onclick="alert('cooming soon...')" class="nav-link" style="color: #dbdbdb;">
                    <i class="link-icon" data-feather="aperture"></i>
                    <span class="link-title">Ajukan Cuti</span>
                </a>
            </li> --}}
        </ul>
    </div>
</nav>