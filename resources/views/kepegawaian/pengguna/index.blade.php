@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/fullcalendar/main.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb breadcrumb-arrwo">
        <li class="breadcrumb-item" aria-current="page">Kepegawaian</li>
        <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
    </ol>
</nav>
<h3 class="page-title mb-2">Data Pengguna</h3>
<div class="row profile-body">
    <!-- middle wrapper start -->

    <div class="col-sm-12 col-md-12 middle-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card rounded">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="ms-2">
                                <h6 class="card-title mb-0">Data Pengguna RSUD Brebes</h6>            
                                </div>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#createPegawai">Tambah Pengguna Baru</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengguna.cari') }}">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                </div>
                                <input type="text" name="cari" class="form-control" id="navbarForm" placeholder="Cari Username atau Nama Pegawai">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Level</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $key => $user)
                                        <tr>
                                            <th scope="row"><small>{{ $key + $users->firstItem() }}</small></th>
                                            <td><small>{{$user->name}}</small></td>
                                            <td><small>{{$user->username}}</small></td>
                                            <td><small>{{$user->email}}</small></td>
                                            <td>
                                                <?php
                                                    $level = "";
                                                    if ($user->level == 0) {
                                                        $level = "Administrator";
                                                    }elseif ($user->level == 1) {
                                                        $level = "Manajemen";
                                                    }elseif ($user->level == 2) {
                                                        $level = "Pegawai";
                                                    }elseif ($user->level == 3) {
                                                        $level = "Persuratan";
                                                    }
                                                ?>
                                                <small>{{$level}}</small>
                                            </td>
                                            <td class="text-center">
                                                <form onsubmit="return confirm('Apakah Anda Yakin mengahapus Akun {{$user->name}}?');" action="{{ route('pengguna.destroy', $user->id) }}" method="POST">
                                                    <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="Reset Password">
                                                    <button type="button" class="btn btn-success btn-xs btn-icon" data-id="{{ $user->id }}" data-bs-target="#passwordReset" data-bs-toggle="modal" alt="Reset Password">
                                                        <i data-feather="key"></i>
                                                    </button></span>
                                                    @if (Auth::user()->level == '0')
                                                    <button type="button" class="btn btn-warning btn-xs btn-icon" data-id="{{ $user->id }}"  data-bs-toggle="modal" data-bs-target="#editPengguna">
                                                        <i data-feather="edit"></i>
                                                    </button>
                                                    @endif
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs btn-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Hapus akun {{$user->name}}">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pull-right mt-4">
                            <ul class="pagination justify-content-center">
                                {{ $users->onEachSide(0)->links('pagination::bootstrap-4') }}
                            </ul>
                            </div>
                            <small>Menampilkan {{$users->count()}} data dari total {{$user_count}} Pegawai.</small>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- middle wrapper end -->
</div>

<div class="modal fade" id="createPegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Form Tambah Pengguna Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form action="{{ route('pengguna.store') }}" method="post">
                @csrf
                <div class="modal-body p-5">
                    <div class="col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label> <sub><code><small>Lengkap dengan Glear</small></code></sub>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="name" placeholder="Nama Pengguna">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="exampleInputUsername1" autocomplete="off" name="email" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label> <sub><code><small>NIP/NIPPPK/NRPBLUD/NRPK</small></code></sub>
                                    <input type="text" class="form-control" id="exampleInputUsername1" autocomplete="off" name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Level</label>
                                    <select name="level" class="form-control" id="">
                                        <option value="">- Pilih Hak Akses -</option>
                                        <option value="0">Administrator</option>
                                        <option value="1">Kepegawaian</option>
                                        <option value="2">Pegawai</option>
                                        <option value="3">Persuratan</option>
                                        <option value="5">Admin Sindikat</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success me-2 mt-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editPengguna" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Ubah Akun Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="editPenggunaForm" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Nama</label> <sub><code><small>Lengkap dengan Glear</small></code></sub>
                                    <input type="text" class="form-control" autocomplete="off" id="name" name="name" placeholder="Nama Pengguna">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" class="form-control" autocomplete="off" id="surel" name="email" placeholder="Nama Pengguna">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Username</label> <sub><code><small>NIP/NIPPPK/NRPBLUD/NRPK</small></code></sub>
                                    <input type="text" class="form-control" autocomplete="off" id="username" name="username" placeholder="Username" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="jabatan_unit_id" class="form-label">Level Pengguna</label>
                                    <select name="level" id="level" class="form-control" id="">
                                        <option value="0">Administrator</option>
                                        <option value="1">Manajemen</option>
                                        <option value="2">Pegawai</option>
                                        <option value="3">Persuratan</option>
                                    </select>
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

<div class="modal fade" id="passwordReset" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Reset Akun Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form id="resetPasswordForm" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Password Default</label>
                                    <input type="text" class="form-control" autocomplete="off" id="name" value="123456" disabled>
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

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/fullcalendar.js') }}"></script>
  <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>

  
  
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        $('#editPengguna').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');
            var url = '/kepegawaian/pengguna/edit/' + userId;


            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    // console.log(data);
                    $('#name').val(data.name);
                    $('#username').val(data.username);
                    $('#surel').val(data.email);
                    $('#level').val(data.level);

                    var formAction = "{{ route('pengguna.update', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#editPenggunaForm').attr('action', formAction);
                },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });

        $('#passwordReset').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var userId = button.data('id');
            var url = '/kepegawaian/pengguna/edit/' + userId;


            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#password').val(data.password);

                    var formAction = "{{ route('pengguna.reset_password', ':id') }}";
                    formAction = formAction.replace(':id', data.id);
                    $('#resetPasswordForm').attr('action', formAction);
                },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });
    });
</script>