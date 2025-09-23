@extends('layout.master_sindikat')
<style>
    <style>
        .landing-section {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .landing-content {
            max-width: 600px;
        }
        .landing-img {
            max-width: 100%;
            height: auto;
        }
        
    
        .program-card {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .program-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .program-icon {
            font-size: 2rem;
            color: #fff;
        }
    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</style>

@section('content')
<div class="container landing-section">
    <div class="row align-items-center">
        <div class="col-md-6 landing-content">
            <h1 class="text-primary">SINDIKAT</h1>
            <h3 class="mt-2">SISTEM INFORMASI PENELITIAN PENDIDIKAN DAN PELATIHAN</h3>
            <p class="mt-3 mb-4">Rumah Sakit Umum Daerah (RSUD) Brebes menyediakan berbagai fasilitas dan layanan untuk mendukung pendidikan, pelatihan, dan penelitian di bidang kesehatan.</p>
            <div class="mt-4" style="padding-top: 30px">
                <img src="{{ url('assets/images/logo_kemenkes_rsud.png') }}" class="img-fluid mb-2" width="160px" alt="">
                <img src="{{ url('assets/images/logo_rsud.svg') }}" class="img-fluid mb-2 mx-2" width="180px" alt="">
            </div>
        </div>
        <div class="col-md-6 text-center">
            <img src="https://images.aspen.edu/wp/uploads/2022/03/GettyImages-628087024-1024x683.jpg" alt="Ilustrasi Rumah Sakit Pendidikan" class="landing-img">
        </div>
    </div>
</div>
<div class="container py-5">
    <h3 class="text-center mb-4">Program Kami</h3>
    <div class="row">
        <!-- Program 1 -->
        <div class="col-md-4 mb-4">
            <div class="program-card p-3 text-center bg-primary text-bg-dark">
                <i class="fas fa-chalkboard-teacher program-icon"></i>
                <h4 class="mt-3">DIKLAT</h4>
                <p>Pelatihan dan pendidikan untuk meningkatkan kompetensi.</p>
            </div>
        </div>
        <!-- Program 2 -->
        <div class="col-md-4 mb-4">
            <div class="program-card p-3 text-center bg-primary text-bg-dark">
                <i class="fas fa-flask program-icon"></i>
                <h4 class="mt-3">LITBANG</h4>
                <p>Penelitian dan pengembangan di bidang kesehatan.</p>
            </div>
        </div>
        <!-- Program 3 -->
        <div class="col-md-4 mb-4">
            <div class="program-card p-3 text-center bg-primary text-bg-dark">
                <i class="fas fa-globe program-icon"></i>
                <h4 class="mt-3">STUDI BANDING</h4>
                <p>Kunjungan untuk mempelajari praktik terbaik di tempat lain.</p>
            </div>
        </div>
        <!-- Program 4 -->
        <div class="col-md-4 mb-4">
            <div class="program-card p-3 text-center bg-primary text-bg-dark">
                <i class="fas fa-cogs program-icon"></i>
                <h4 class="mt-3">IHT</h4>
                <p>In House Training untuk pengembangan internal Pegawai RSUD Brebes.</p>
            </div>
        </div>
        <!-- Program 5 -->
        <div class="col-md-4 mb-4">
            <div class="program-card p-3 text-center bg-primary text-bg-dark">
                <i class="fas fa-hands-helping program-icon"></i>
                <h4 class="mt-3">PENGABDIAN MASYARAKAT</h4>
                <p>Kegiatan pengabdian untuk meningkatkan kesejahteraan masyarakat.</p>
            </div>
        </div>
        <!-- Program 6 -->
        <div class="col-md-4 mb-4">
            <div class="program-card p-3 text-center bg-primary text-bg-dark">
                <i class="fas fa-book program-icon"></i>
                <h4 class="mt-3">PERPUSTAKAAN</h4>
                <p>Fasilitas perpustakaan untuk mendukung kegiatan belajar mengajar.</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <h3 class="text-center mb-4">Arsip Materi Terbaru</h3>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card text-white">
                <img src="https://s3.amazonaws.com/utep-uploads/wp-content/uploads/online-regis-college/2023/07/27081855/nursing-students-working-together.jpg" class="card-img" alt="...">
                <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                    <h5 class="card-title">Card title 1</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card text-white">
                <img src="https://www.nursingworld.org/~4aebc2/globalassets/resources/students-in-class.jpg" class="card-img" alt="...">
                <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                    <h5 class="card-title">Card title 2</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card text-white">
                <img src="https://www.sentinelu.com/wp-content/uploads/2016/12/SentinelU-Histotry-of-nursing-education-jpg.webp" class="card-img" alt="...">
                <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                    <h5 class="card-title">Card title 3</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center my-4">
        <button type="button" class="btn btn-outline-primary">Materi Lainnya</button>
    </div>
</div>

<div class="container mt-5">
    <h3 class="text-center mb-4">Dokumentasi Kegiatan</h3>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card text-white">
                <img src="https://s3.amazonaws.com/utep-uploads/wp-content/uploads/online-regis-college/2023/07/27081855/nursing-students-working-together.jpg" class="card-img" alt="...">
                <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                    <h5 class="card-title">Kegiatan 1</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card text-white">
                <img src="https://www.nursingworld.org/~4aebc2/globalassets/resources/students-in-class.jpg" class="card-img" alt="...">
                <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                    <h5 class="card-title">Kegiatan 2</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="card text-white">
                <img src="https://www.sentinelu.com/wp-content/uploads/2016/12/SentinelU-Histotry-of-nursing-education-jpg.webp" class="card-img" alt="...">
                <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
                    <h5 class="card-title">Kegiatan 3</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text">Last updated 3 mins ago</p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center my-4">
        <button type="button" class="btn btn-outline-primary">Dokumentasi Lainnya</button>
    </div>
</div>
@endsection
