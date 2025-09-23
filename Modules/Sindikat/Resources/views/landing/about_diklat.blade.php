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
            <h1 class="text-primary mt-4">DIKLAT</h1>
            <h3 class="mt-2">PENDIDIKAN DAN PELATIHAN</h3>
            <p class="mt-3" style="font-size:16px">Pendidikan dan Pelatihan (Diklat) di bidang RSUD Brebes memegang peranan penting dalam meningkatkan kualitas layanan kesehatan. Diklat ini bertujuan untuk memastikan bahwa tenaga medis dan non-medis memiliki pengetahuan dan keterampilan yang mutakhir serta relevan dengan perkembangan terbaru di dunia kesehatan. Dalam lingkungan yang dinamis dan penuh tantangan seperti rumah sakit, Diklat membantu profesional kesehatan untuk selalu siap menghadapi berbagai situasi medis dengan cepat dan tepat.<p>

            <p class="mt-3" style="font-size:16px">Program Diklat di rumah sakit sering kali mencakup berbagai topik mulai dari teknologi medis terbaru, prosedur klinis, manajemen risiko, hingga keterampilan komunikasi yang efektif. Selain itu, pelatihan ini juga berfokus pada aspek-aspek non-klinis seperti administrasi rumah sakit, manajemen keuangan, dan kebijakan kesehatan. Melalui pendekatan yang komprehensif, Diklat memastikan bahwa setiap aspek operasional rumah sakit dapat berjalan dengan efisien dan memberikan pelayanan terbaik kepada pasien.</p>
            
            <p class="mt-3" style="font-size:16px">Tidak hanya itu, Diklat di rumah sakit juga berperan dalam meningkatkan kerjasama tim dan budaya organisasi. Melalui berbagai kegiatan pelatihan bersama, staf medis dan non-medis dapat memperkuat hubungan profesional dan membangun kerjasama yang solid. Ini sangat penting mengingat bahwa rumah sakit adalah ekosistem yang kompleks di mana kerjasama antar berbagai departemen dan disiplin ilmu sangat diperlukan untuk memberikan perawatan yang holistik dan berkualitas tinggi kepada pasien. Dengan demikian, Diklat menjadi fondasi yang kuat untuk menciptakan lingkungan kerja yang harmonis dan produktif di rumah sakit.</p>
        </div>
        <div class="col-md-6 text-center">
            <img src="https://images.aspen.edu/wp/uploads/2022/03/GettyImages-628087024-1024x683.jpg" alt="Ilustrasi Rumah Sakit Pendidikan" class="landing-img">
        </div>
    </div>
</div>
@endsection
