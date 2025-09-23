<nav class="sidebar sidebar-dark">
    <div class="sidebar-header">
      <a href="#" class="sidebar-brand">
        SIN-<span>DIKAT</span>
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
      <ul class="nav">
        @if (Auth::user()->level == 0)
        <li class="nav-item {{ active_class(['/']) }}">
          <a href="{{ url('/') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li>
        
        <li class="nav-item nav-category">MASTER</li>
        <li class="nav-item {{ request()->routeIs('unit.index') || request()->routeIs('jabatan_unit.index') ? 'active' : '' }}">
          <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="{{ is_active_route(['unit/*']) }}" aria-controls="uiComponents">
            <i class="link-icon mdi mdi-hospital-building"></i>
            <span class="link-title">Jenjang</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse {{ request()->routeIs('unit.index') || request()->routeIs('jabatan_unit.index') ? 'active show' : '' }}" id="uiComponents">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ url('/kepegawaian/unit') }}" class="nav-link {{ request()->routeIs('unit.index') ? 'active' : '' }}">Unit / Bagian</a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/kepegawaian/jabatan_unit') }}" class="nav-link {{ request()->routeIs('jabatan_unit.index') ? 'active' : '' }}">Jabatan Unit</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item {{ request()->routeIs('kelompok_jabatan.index') || request()->routeIs('jabatan.index') ? 'active' : '' }}">
          <a class="nav-link" data-bs-toggle="collapse" href="#email" role="button" aria-expanded="{{ is_active_route(['jabatan/*']) }}" aria-controls="email">
            <i class="link-icon" data-feather="briefcase"></i>
            <span class="link-title">Data Jabatan</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse  {{ request()->routeIs('kelompok_jabatan.index') || request()->routeIs('jabatan.index') ? 'active show' : '' }}" id="email">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ url('/kepegawaian/kelompok_jabatan') }}" class="nav-link {{ request()->routeIs('kelompok_jabatan.index') ? 'active' : '' }}">Kelompok Jabatan</a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/kepegawaian/jabatan') }}" class="nav-link {{ request()->routeIs('jabatan.index') ? 'active' : '' }}">Jabatan Pegawai</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item {{ request()->routeIs('data_pegawai.index') ? 'active' : '' }}">
          <a href="{{ url('/kepegawaian/data_pegawai') }}" class="nav-link">
            <i class="link-icon" data-feather="users"></i>
            <span class="link-title">Data Pegawai</span>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('pengguna.index') ? 'active' : '' }}">
          <a href="{{ url('/kepegawaian/pengguna') }}" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">Data Pengguna</span>
          </a>
        </li>
        @endif
        @if (Auth::user()->level == 0 || Auth::user()->level == 1)
  
        <li class="nav-item nav-category">PERSURATAN</li>
  
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#persuratan" role="button" aria-expanded="{{ is_active_route(['persuratan/*']) }}" aria-controls="persuratan">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Surat Keluar</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse {{ is_active_route(['persuratan/*']) }}" id="persuratan">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="" onclick="alert('under development')" class="nav-link {{ active_class(['advanced-ui/cropper']) }}">Buat Surat Baru</a>
              </li>
              <li class="nav-item">
                <a href="" onclick="alert('under development')" class="nav-link {{ active_class(['advanced-ui/cropper']) }}">Data Surat Keluar</a>
              </li>
              <li class="nav-item">
                <a href="" onclick="alert('under development')" class="nav-link {{ active_class(['advanced-ui/owl-carousel']) }}">Rekap Surat Keluar</a>
              </li>
            </ul>
          </div>
        </li>
        <li class="nav-item {{ request()->routeIs('unit_organisasi.index') ? 'active' : '' }}">
          <a href="{{ url('/persuratan/unit_organisasi') }}" class="nav-link">
            <i class="link-icon" data-feather="map-pin"></i>
            <span class="link-title">Data SKPD</span>
          </a>
        </li>
        <li class="nav-item {{ active_class(['apps/chat']) }}">
          <a href="" onclick="alert('cooming soon...')" class="nav-link">
            <i class="link-icon" data-feather="check"></i>
            <span class="link-title">Data Pola Klasifikasi</span>
          </a>
        </li>
        <li class="nav-item {{ active_class(['apps/chat']) }}">
          <a href="{{ url('/persuratan/jenis_surat') }}" class="nav-link">
            <i class="link-icon" data-feather="file"></i>
            <span class="link-title">Data Jenis Surat</span>
          </a>
        </li>
        @elseif (Auth::user()->level == 2)
  
        @if (isset($pegawai) && $pegawai->status_pegawai != 1)
          
        <li class="nav-item nav-category">PEGAWAI</li>
       
        <li li class="nav-item {{ request()->routeIs('data_pegawai.profil') || request()->routeIs('data_pegawai.pasangan') || request()->routeIs('data_pegawai.anak') ? 'active' : '' }}">
          <a class="nav-link" data-bs-toggle="collapse" href="#advanced-ui" role="button" aria-expanded="{{ is_active_route(['advanced-ui/*']) }}" aria-controls="advanced-ui">
            <i class="link-icon" data-feather="user-check"></i>
            <span class="link-title">Data Diri</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
          </a>
          <div class="collapse {{ request()->routeIs('data_pegawai.profil') || request()->routeIs('data_pegawai.pasangan') || request()->routeIs('data_pegawai.anak') ? 'active show' : '' }}" id="advanced-ui">
            <ul class="nav sub-menu">
              <li class="nav-item">
                <a href="{{ url('/kepegawaian/pegawai/profil') }}" class="nav-link {{ request()->routeIs('data_pegawai.profil') ? 'active' : '' }}">Biodata Diri</a>
              </li>
              <li class="nav-item">
                <a href="{{route('data_pegawai.pasangan', $pegawai->id)}}" class="nav-link {{ request()->routeIs('data_pegawai.pasangan') ? 'active' : '' }}">Suami/Istri</a>
                </li>
                <li class="nav-item">
              <a href="{{route('data_pegawai.anak', $pegawai->id)}}" class="nav-link {{ request()->routeIs('data_pegawai.anak') ? 'active' : '' }}">Anak</a>
              </li>
              <li class="nav-item">
                <a href="{{route('data_pegawai.dokumen', $pegawai->id)}}" class="nav-link {{ request()->routeIs('data_pegawai.dokumen') ? 'active' : '' }}">Dokumen</a>
                </li>
            </ul>
          </div>
        </li>
  
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_jabatan') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_jabatan', $pegawai->id)}}" class="nav-link">
            <i class="link-icon" data-feather="briefcase"></i>
            <span class="link-title">Riwayat Jabatan Pegawai</span>
          </a>
        </li>
  
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_jabatan_unit') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_jabatan_unit', $pegawai->id)}}" class="nav-link">
            <i class="link-icon" data-feather="user-check"></i>
            <span class="link-title">Riwayat Jabatan Unit</span>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_pendidikan') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_pendidikan', $pegawai->id)}}" class="nav-link">
            <i class="link-icon" data-feather="pen-tool"></i>
            <span class="link-title">Riwayat Pendidikan</span>
          </a>
        </li>
  
        @if ($pegawai->status_kepegawaian == 'PNS' || $pegawai->status_kepegawaian == 'PPPK')
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_golongan') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_golongan', $pegawai->id)}}" class="nav-link">
            <i class="link-icon" data-feather="list"></i>
            <span class="link-title">Riwayat Golongan</span>
          </a>
        </li>
        @endif
  
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_diklat') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_diklat', $pegawai->id)}}" class="nav-link">
            <i class="link-icon" data-feather="award"></i>
            <span class="link-title">Riwayat Diklat</span>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_karya_ilmiah') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_karya_ilmiah', $pegawai->id)}}" class="nav-link">
            <i class="link-icon mdi mdi-chemical-weapon"></i>
            <span class="link-title">Riwayat Karya Ilmiah</span>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_pekerjaan') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_pekerjaan', $pegawai->id)}}" class="nav-link">
            <i class="link-icon mdi mdi-account-box-outline"></i>
            <span class="link-title">Riwayat Pekerjaan</span>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_organisasi') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_organisasi', $pegawai->id)}}" class="nav-link">
            <i class="link-icon mdi mdi-google-circles-extended"></i>
            <span class="link-title">Riwayat Organisasi</span>
          </a>
        </li>
        <li class="nav-item {{ request()->routeIs('data_pegawai.riwayat_pegawai_ci') ? 'active' : '' }}">
          <a href="{{route('data_pegawai.riwayat_pegawai_ci', $pegawai->id)}}" class="nav-link">
            <i class="link-icon mdi mdi-account-network"></i>
            <span class="link-title">Riwayat Instruktur Klinik</span>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a href="#" onclick="alert('cooming soon...')"  class="nav-link">
            <i class="link-icon mdi mdi-trending-up"></i>
            <span class="link-title">Evaluasi Kinerja Pegawai</span>
          </a>
        </li> --}}
        @endif
        @endif
        {{-- <li class="nav-item nav-category">PORTAL</li>
        <li class="nav-item {{ active_class(['apps/chat']) }}">
          <a href="" onclick="alert('cooming soon...')" class="nav-link">
            <i class="link-icon" data-feather="aperture"></i>
            <span class="link-title">Rekap Kehadiran</span>
          </a>
        </li>
        <li class="nav-item {{ active_class(['apps/chat']) }}">
          <a href="" onclick="alert('cooming soon...')" class="nav-link">
            <i class="link-icon" data-feather="aperture"></i>
            <span class="link-title">E-Kinerja</span>
          </a>
        </li>
        <li class="nav-item {{ active_class(['apps/chat']) }}">
          <a href="" onclick="alert('cooming soon...')" class="nav-link">
            <i class="link-icon" data-feather="aperture"></i>
            <span class="link-title">Hukuman Disiplin</span>
          </a>
        </li>
        <li class="nav-item {{ active_class(['apps/chat']) }}">
          <a href="" onclick="alert('cooming soon...')" class="nav-link">
            <i class="link-icon" data-feather="aperture"></i>
            <span class="link-title">Ajukan Cuti</span>
          </a>
        </li> --}}
      </ul>
    </div>
  </nav>