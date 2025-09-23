<div class="col-12 mb-4">
    <div class="list-group">
        <a href="{{route('sindikat.institusi.show', $institusi->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('sindikat.institusi.show') ? 'active' : '' }}"><i class="mdi mdi-office-building mx-2"></i> Profil Institusi</a>
        <a href="{{route('sindikat.institusi.jurusan', $institusi->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('sindikat.institusi.jurusan') ? 'active' : '' }}"><i class="mdi mdi-book-multiple mx-2"></i> Data Jurusan</a>
        <a href="{{route('sindikat.institusi.peserta_didik', $institusi->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('sindikat.institusi.peserta_didik') ? 'active' : '' }}"><i class="mdi mdi-account-multiple-plus mx-2"></i> Data Peserta Didik </a>
        <a href="{{route('sindikat.institusi.permohonan_magang', $institusi->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('sindikat.institusi.permohonan_magang') ? 'active' : '' }}"><i class="mdi mdi-file-check mx-2"></i> Riwayat Permohonan Co-Ass/Magang</a>
        {{-- <a href="{{route('sindikat.institusi.permohonan_studibanding', $institusi->id)}}" class="list-group-item list-group-item-action {{ request()->routeIs('sindikat.institusi.permohonan_studibanding') ? 'active' : '' }}"><i class="mdi mdi-calendar-plus mx-2"></i> Riwayat Permohonan Studi Banding</a> --}}
        {{-- <a href="#" onclick="alert('cooming soon...')" class="list-group-item list-group-item-action {{ request()->routeIs() ? 'active' : '' }}"><i class="mdi mdi mdi-trending-up mx-2"></i> Evaluasi Kinerja Pegawai</a> --}}
    </div>
</div>
