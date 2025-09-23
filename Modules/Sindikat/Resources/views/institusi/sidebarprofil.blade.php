<div class="card rounded">
    <div class="card-body">
        <div class="text-center mb-4 mt-2">
            @if ($magang->institusi->logo == null)
            <img src="{{ asset('assets/images/user-icon.png') }}" class="wd-100 wd-sm-100 me-3 mb-1" alt="...">
            @else
            <img src="{{ asset('storage/sindikat/institusi/logo/'.$magang->institusi->logo) }}" class="wd-100 wd-sm-100 me-3 mb-1" alt="...">
            @endif
        </div>
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="card-title mb-0"><a href="{{route('sindikat.institusi.show', $magang->institusi_id)}}">{{$magang->institusi->nama}}</a></h6>
        </div>
        <p>{{$magang->institusi->alamat}} {{Str::title($magang->institusi->kota)}} {{Str::title($magang->institusi->provinsi)}}</p>
        <div class="mt-3">
            <label class="fs-11px fw-bolder mb-0 text-uppercase">Join Sindikat:</label>
            <p class="text-secondary">{{date_format(date_create($magang->institusi->created), 'd M Y')}}</p>
        </div>
        <div class="mt-3">
            <label class="fs-11px fw-bolder mb-0 text-uppercase">Tingkatan:</label>
            @php
            $level = "";
            if ($magang->institusi->level == 1) {
                $level = "Perguruan Tinggi";
            }else if($magang->institusi->level == 2){
                $level = "SMK";
            }else{
                $level = "Institusi Pendidikan Non Formal";
            }
        @endphp
            <p class="text-secondary">{{$level}}</p>
        </div>

        <div class="mt-3">
            <label class="fs-11px fw-bolder mb-0 text-uppercase">Email:</label>
            <p class="text-secondary">{{$magang->institusi->email}} </p>
        </div>
        <div class="mt-3">
            <label class="fs-11px fw-bolder mb-0 text-uppercase">Telp:</label>
            <p class="text-secondary">{{$magang->institusi->telp}} </p>
        </div>
    </div>
</div>