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
        

    </style>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</style>

@section('content')
<div class="container landing-section">
    <div class="row align-items-center">
        <div class="col-md-6 landing-content p-4">
            <h1 class="text-primary mt-4">LITBANG</h1>
            <h3 class="mt-2">PENELITIAN DAN PENGEMBANGAN</h3>
            <p class="mt-3" style="font-size:16px">Penelitian dan Pengembangan (Litbang) di RSUD Brebes memainkan peran krusial dalam mendorong inovasi dan peningkatan layanan kesehatan. Litbang bertanggung jawab untuk melakukan penelitian mendalam yang dapat memberikan wawasan baru tentang berbagai penyakit, metode pengobatan, dan teknologi medis. Melalui kegiatan penelitian ini, rumah sakit tidak hanya berperan sebagai penyedia layanan kesehatan tetapi juga sebagai pusat pengetahuan yang aktif berkontribusi terhadap kemajuan medis secara global. Hasil dari penelitian ini dapat digunakan untuk mengembangkan protokol perawatan baru, meningkatkan efektivitas terapi, dan mengurangi risiko komplikasi bagi pasien.<p>

            <p class="mt-3" style="font-size:16px">Di bidang pengembangan, Litbang berfokus pada penerapan hasil penelitian ke dalam praktik klinis serta pengembangan teknologi dan perangkat medis yang inovatif. Pengembangan ini melibatkan kolaborasi erat antara peneliti, dokter, insinyur, dan profesional kesehatan lainnya. Dengan memanfaatkan teknologi terbaru seperti kecerdasan buatan, big data, dan bioteknologi, Litbang berusaha untuk menciptakan solusi medis yang lebih efektif, efisien, dan terjangkau. Selain itu, Litbang juga berupaya untuk meningkatkan kualitas manajemen rumah sakit melalui pengembangan sistem informasi yang canggih dan proses operasional yang lebih baik.</p>
            
            <p class="mt-3" style="font-size:16px">Litbang di rumah sakit juga berperan penting dalam pendidikan dan pelatihan tenaga medis. Melalui program-program pelatihan yang didasarkan pada hasil penelitian terbaru, Litbang memastikan bahwa dokter, perawat, dan tenaga medis lainnya selalu berada di garis depan dalam pengetahuan dan keterampilan medis. Ini tidak hanya meningkatkan kualitas perawatan yang diberikan kepada pasien tetapi juga membangun reputasi rumah sakit sebagai institusi yang berkomitmen pada keunggulan dan inovasi. Dengan demikian, Litbang menjadi pilar utama dalam upaya rumah sakit untuk terus beradaptasi dengan perkembangan ilmu pengetahuan dan teknologi, serta memenuhi kebutuhan kesehatan masyarakat yang terus berkembang..</p>
        </div>
        <div class="col-md-6 text-center">
            <img src="https://img.freepik.com/premium-photo/doctor-working-futuristic-hospital-with-medical-high-tech-healthcare_853677-77098.jpg" alt="Ilustrasi Rumah Sakit Pendidikan" class="landing-img">
        </div>
    </div>
</div>
@endsection
