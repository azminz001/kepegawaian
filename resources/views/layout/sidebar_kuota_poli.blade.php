<nav class="sidebar sidebar-dark">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
        SIM-<span>RSUD</span>
        </a>
        <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
        <li class="nav-item {{ active_class(['/']) }}">
            <a href="{{ url('/') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item nav-category">PENGATURAN KUOTA POLI</li>
        <li class="nav-item {{ active_class(['ui-components/*']) }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#uiComponents" role="button" aria-expanded="{{ is_active_route(['ui-components/*']) }}" aria-controls="uiComponents">
            <i class="link-icon" data-feather="feather"></i>
            <span class="link-title">Data Unit</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['ui-components/*']) }}" id="uiComponents">
            <ul class="nav sub-menu">
                <li class="nav-item">
                <a href="{{ url('/ui-components/accordion') }}" class="nav-link {{ active_class(['ui-components/accordion']) }}">Unit / Bagian</a>
                </li>
                <li class="nav-item">
                <a href="{{ url('/ui-components/alerts') }}" class="nav-link {{ active_class(['ui-components/alerts']) }}">Jabatan Unit</a>
                </li>
            </ul>
            </div>
        </li>
        <li class="nav-item {{ active_class(['email/*']) }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#email" role="button" aria-expanded="{{ is_active_route(['email/*']) }}" aria-controls="email">
            <i class="link-icon" data-feather="mail"></i>
            <span class="link-title">Data Jabatan</span>
            <i class="link-arrow" data-feather="chevron-down"></i>
            </a>
            <div class="collapse {{ show_class(['email/*']) }}" id="email">
            <ul class="nav sub-menu">
                <li class="nav-item">
                <a href="{{ url('/email/inbox') }}" class="nav-link {{ active_class(['email/inbox']) }}">Jenis Jabatan</a>
                </li>
                <li class="nav-item">
                <a href="{{ url('/email/read') }}" class="nav-link {{ active_class(['email/read']) }}">Kelompok Jabatan</a>
                </li>
                <li class="nav-item">
                <a href="{{ url('/email/compose') }}" class="nav-link {{ active_class(['email/compose']) }}">Jabatan Pegawai</a>
                </li>
            </ul>
            </div>
        </li>
        <li class="nav-item {{ active_class(['apps/chat']) }}">
            <a href="{{ url('/apps/chat') }}" class="nav-link">
            <i class="link-icon" data-feather="message-square"></i>
            <span class="link-title">Pegawai</span>
            </a>
        </li>
        <li class="nav-item {{ active_class(['apps/calendar']) }}">
            <a href="{{ url('/apps/calendar') }}" class="nav-link">
            <i class="link-icon" data-feather="calendar"></i>
            <span class="link-title">Pengguna</span>
            </a>
        </li>
        </ul>
    </div>
</nav>