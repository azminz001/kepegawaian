@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item active" aria-current="page">WhatsApp Pesan Broadcast</li>
    </ol>
</nav>
<h3 class="page-title mb-2">WhatsApp Broadcast</h3>
<div class="card p-2">
    <form action="{{route('whatsappapi.sendBroadCast')}}" method="post">
      @csrf
      <div class="row">
          <div class="col-md-8 pe-0">
            <div class="card m-2">
              <div class="alert alert-primary m-2" role="alert">
                <strong>Tutorial</strong>
                <ul>
                  <li>Untuk membuat teks Anda miring, masukkan dalam garis bawah: _teks_</li>
                  <li>Untuk menebalkan teks, masukkan dalam tanda bintang: *teks*</li>
                  <li>Untuk mencoret teks Anda, lampirkan dalam tanda tilde: ~text~</li>
                  <li>Untuk menulis dalam monospace, tempatkan tiga tanda centang terbalik di setiap sisi teks: ```teks ```</li>
                  <li>Untuk menambahkan kode sebaris, lampirkan dalam tanda kutip terbalik: `teks` </li>
                </ul>
              </div>
              <div class="card-body">
                <h4 class="card-title">Isi Pesan</h4>
                <textarea name="pesan" class="form-control" rows="10"></textarea>
              </div>
            </div>
          </div>
          <div class="col-md-4 ps-0">
            <div class="card m-2">
                <div class="alert alert-danger m-2" role="alert">
                  <strong>Peringatan</strong>
                  <p>Semakin banyak nomor tujuan yang dipilih, semakin lama proses pengiriman pesan karena sistem akan 
                    memproses sesuai jumlah tujuan. Setiap pengiriman akan di jeda selama 15 detik agar WhatsApp Akun tidak dibanned dan Pesan harus bersifat informatif. 
                    <strong>Saat pesan dikirim mohon tidak menutup tab browser hingga muncul notifikasi bahwa pengiriman selesai.</strong>
                  </p>
                  <strong>Saran: </strong> <br>Lakukan Pengiriman secara bergantian untuk setiap 10-15 nomor tujuan
                </div>
                <div class="card-body">
                  <h4 class="card-title">Tujuan Pesan Kepada</h4>
                  {{-- <div class="form-check mb-2">
                    <input type="radio" class="form-check-input" name="tujuan" value="semua" id="radioSemua" checked>
                    <label class="form-check-label" for="radioSemua">Semua Pegawai</label>
                  </div> --}}
                  {{-- <div class="form-check mb-2">
                    <input type="radio" class="form-check-input" name="tujuan" id="radioPilih">
                    <label class="form-check-label" for="radioPilih">Pilih Pegawai</label>
                  </div> --}}
                  <div id="selectPegawai" >
                    <select
                      class="js-example-basic-multiple form-select select2"
                      name="pegawai_id[]"
                      multiple="multiple"
                      data-width="100%"
                    >
                      @foreach ($pegawai as $employee)
                        <option value="{{$employee->id}}">{{$employee->nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="m-2">
                <button type="submit" name="submit" id="" class="btn btn-success btn-block w-100"><span class="mdi mdi-whatsapp mx-2"></span> KIRIM</button>
              </div>
          </div>
      </div>
    </form>
</div>


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  @endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/tinymce.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script>
  // Ambil elemen radio buttons dan dropdown
  const radioSemua = document.getElementById('radioSemua');
  const radioPilih = document.getElementById('radioPilih');
  const selectPegawai = document.getElementById('selectPegawai');

  // Fungsi untuk mengatur visibilitas dropdown
  function toggleSelectPegawai() {
    if (radioPilih.checked) {
      selectPegawai.style.display = 'block'; // Tampilkan dropdown
    } else {
      selectPegawai.style.display = 'none'; // Sembunyikan dropdown
    }
  }

  // Tambahkan event listener untuk mendeteksi perubahan
  radioSemua.addEventListener('change', toggleSelectPegawai);
  radioPilih.addEventListener('change', toggleSelectPegawai);

  // Panggil fungsi saat halaman pertama kali dimuat
  toggleSelectPegawai();

  </script>

@endpush
