<!-- filepath: resources/views/landing.blade.php -->
@extends('layouts.layout')

@section('title', 'ReWasteX - Solusi Digital untuk Kota yang Lebih Bersih')

@push('styles')
<style>
    .hero-gradient {
        background: linear-gradient(135deg, #4a90e2 0%, #357abd 35%, #28a745 100%);
        position: relative;
        overflow: hidden;
    }
    
    .hero-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,1000 1000,800 1000,1000"/></svg>');
        z-index: 1;
    }
    
    .hero-content {
        position: relative;
        z-index: 2;
        padding: 120px 0 80px;
    }
    
    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
        transition: transform 0.3s ease;
    }
    
    .feature-icon:hover {
        transform: translateY(-5px);
    }
    
    .feature-icon i {
        font-size: 2rem;
        color: white;
    }
    
    .mission-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        border-left: 5px solid #28a745;
        transition: transform 0.3s ease;
        height: 100%;
    }
      .mission-card:hover {
        transform: translateY(-5px);
    }
    
    .mission-icon-wrapper {
        width: 60px;
        height: 60px;
        min-width: 60px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .mission-icon-wrapper i {
        font-size: 1.5rem;
        color: white;
    }
    
    .mission-card-special {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-left: 5px solid #007bff;
        position: relative;
        overflow: hidden;
    }
    
    .mission-card-special::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20px;
        width: 100px;
        height: 200%;
        background: linear-gradient(45deg, rgba(0,123,255,0.05), rgba(40,167,69,0.05));
        transform: rotate(15deg);
        z-index: 1;
    }
    
    .mission-card-special .d-flex {
        position: relative;
        z-index: 2;
    }
    
    .mission-icon-sdg {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border-radius: 12px;
        position: relative;
    }
    
    .sdg-badge {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    
    .sdg-number {
        font-size: 1.8rem;
        font-weight: 900;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .sdg-info {
        margin-top: 10px;
        padding: 8px 12px;
        background: rgba(40, 167, 69, 0.1);
        border-radius: 8px;
        border-left: 3px solid #28a745;
    }
    
    .team-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        box-shadow: 0 15px 50px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        height: 100%;
    }
    
    .team-card:hover {
        transform: translateY(-10px);
    }
      .team-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4a90e2, #28a745);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 3rem;
        font-weight: bold;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    
    .team-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }.accordion {
        border: none;
    }
    
    .accordion-item {
        border: none !important;
        background: transparent;
    }
      .faq-card {
        background: transparent;
        border-radius: 20px;
        border: 1px solid rgba(40, 167, 69, 0.1);
        box-shadow: 0 8px 30px rgba(0,0,0,0.06);
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .faq-card:hover {
        box-shadow: 0 15px 40px rgba(40, 167, 69, 0.15);
        transform: translateY(-2px);
        border-color: rgba(40, 167, 69, 0.2);
    }
    
    .accordion-header {
        border: none;
        margin-bottom: 0;
    }    .accordion-button {
        background: white !important;
        border: none !important;
        padding: 25px 30px;
        color: #2d3436 !important;
        text-decoration: none !important;
        font-weight: 600;
        font-size: 1.1rem;
        border-radius: 20px !important;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: none !important;
        width: 100%;
    }
    
    /* When accordion item is expanded, only round top corners */
    .accordion-button:not(.collapsed) {
        border-radius: 20px 20px 0 0 !important;
        background: linear-gradient(135deg, #f8fcf9, #f0f8f2) !important;
    }
    
    /* When accordion item is collapsed, round all corners */
    .accordion-button.collapsed {
        border-radius: 20px !important;
        background: white !important;
    }
    
    .accordion-button:not(.collapsed) {
        color: #28a745 !important;
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(32, 201, 151, 0.1)) !important;
        border-bottom: 1px solid rgba(40, 167, 69, 0.1) !important;
    }
    
    .accordion-button:hover {
        color: #28a745 !important;
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.05), rgba(32, 201, 151, 0.05)) !important;
    }
    
    .accordion-button::after {
        background-image: none !important;
        content: '\F229' !important;
        font-family: 'bootstrap-icons' !important;
        font-size: 1.2rem !important;
        color: #6c757d !important;
        transition: all 0.3s ease !important;
        transform: none !important;
    }
    
    .accordion-button:not(.collapsed)::after {
        content: '\F228' !important;
        color: #28a745 !important;
        transform: rotate(180deg) !important;
    }
    
    .accordion-button .bi {
        transition: all 0.3s ease;
        font-size: 1.3rem;
    }
    
    .accordion-button:not(.collapsed) .bi {
        transform: scale(1.1);
    }
    
    .accordion-button:focus {
        box-shadow: none !important;
        border: none !important;
        outline: none !important;
    }
    
    .accordion-collapse {
        border: none;
    }
      .accordion-body {
        padding: 25px 30px 30px;
        background: white;
        border-radius: 0 0 20px 20px !important;
    }
    
    .accordion-body p {
        margin-bottom: 0;
        line-height: 1.7;
        color: #5a6c7d;
        font-size: 1rem;
    }
    
    .section-title {
        position: relative;
        padding-bottom: 20px;
        margin-bottom: 50px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 2px;
    }
    
    .contact-info-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.1);
        height: 100%;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        transition: background 0.3s ease;
    }
    
    .contact-item:hover {
        background: #e9ecef;
    }
    
    .contact-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: white;
    }
</style>
@endpush

@section('content')

            <!-- Hero Section -->
            <section class="hero-gradient">
                <div class="hero-content">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-12">
                                <h1 class="display-4 fw-bold text-white mb-4">
                                    🌱 <span class="text-warning">ReWasteX</span><br>
                                    Solusi Digital untuk Kota yang Lebih Bersih
                                </h1>
                                <p class="lead text-white-50 mb-4">
                                    Platform digital berbasis web yang menghubungkan masyarakat, pelaku daur ulang, dan pemerintah kota dalam satu ekosistem terintegrasi untuk Bandung yang lebih bersih dan berkelanjutan.
                                </p>
                                <div class="d-flex flex-wrap gap-3">
                                    <a href="#tentang" class="btn btn-light btn-lg px-4 py-3 rounded-pill">
                                        <i class="bi bi-arrow-down-circle me-2"></i>Pelajari Lebih Lanjut
                                    </a>
                                    <a href="/register" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                                        <i class="bi bi-person-plus me-2"></i>Bergabung Sekarang
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 mt-5 mt-lg-0">
                                <div class="text-center">
                                    <div class="feature-icon mx-auto mb-4" style="width: 200px; height: 200px;">
                                        <i class="bi bi-recycle" style="font-size: 5rem;"></i>
                                    </div>
                                    <h3 class="text-white mb-3">SDG 12: Responsible Consumption</h3>
                                    <p class="text-white-50">Mendukung ekonomi sirkular untuk masa depan yang berkelanjutan</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>            <!-- Tentang ReWasteX Section -->
            <section class="section-padding" id="tentang">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="section-title">🌱 Tentang ReWasteX</h2>
                            <p class="lead text-muted mb-5">Solusi Digital untuk Kota yang Lebih Bersih</p>
                        </div>
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-lg-8 col-12 mx-auto">
                            <div class="text-center">
                                <p class="fs-5 text-muted mb-4">
                                    ReWasteX adalah platform digital berbasis web yang hadir sebagai solusi cerdas untuk permasalahan sampah di Kota Bandung. Dengan pendekatan user-friendly dan teknologi mutakhir, ReWasteX menghubungkan masyarakat, pelaku daur ulang, dan pemerintah kota dalam satu ekosistem yang terintegrasi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Fitur Utama -->
                    <div class="row g-4 mb-5">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Pemetaan Lokasi</h5>
                                <p class="text-muted">Temukan lokasi daur ulang terdekat dengan mudah melalui sistem pemetaan interaktif</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="bi bi-award-fill"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Sistem Reward</h5>
                                <p class="text-muted">Dapatkan poin dan hadiah menarik untuk setiap aktivitas daur ulang yang Anda lakukan</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="bi bi-book-fill"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Edukasi</h5>
                                <p class="text-muted">Pelajari cara memilah sampah yang benar dan manfaat daur ulang untuk lingkungan</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="text-center">
                                <div class="feature-icon">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <h5 class="fw-bold mb-3">Pemantauan</h5>
                                <p class="text-muted">Tracking aktivitas daur ulang real-time untuk optimalisasi pengelolaan sampah</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Misi Section -->
            <section class="section-padding section-bg" id="misi">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-center mb-5">
                            <h2 class="section-title">🎯 Misi Kami</h2>
                        </div>
                    </div>
                      <div class="row g-4">
                        <div class="col-lg-6 col-12">
                            <div class="mission-card">
                                <div class="d-flex align-items-start">
                                    <div class="mission-icon-wrapper me-3">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-3">Meningkatkan Kesadaran Masyarakat</h5>
                                        <p class="text-muted mb-0">Meningkatkan kesadaran masyarakat dalam memilah dan mendaur ulang sampah melalui edukasi yang mudah dipahami dan praktis.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="mission-card">
                                <div class="d-flex align-items-start">
                                    <div class="mission-icon-wrapper me-3">
                                        <i class="bi bi-gift-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-3">Sistem Insentif Berkelanjutan</h5>
                                        <p class="text-muted mb-0">Menyediakan sistem insentif berupa poin dan hadiah untuk mendorong partisipasi aktif masyarakat dalam program daur ulang.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="mission-card">
                                <div class="d-flex align-items-start">
                                    <div class="mission-icon-wrapper me-3">
                                        <i class="bi bi-bar-chart-fill"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-3">Dukungan Pemerintah Kota</h5>
                                        <p class="text-muted mb-0">Membantu pemerintah dalam pemantauan dan optimalisasi pengelolaan sampah dengan data real-time yang akurat.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="mission-card mission-card-special">
                                <div class="d-flex align-items-start">
                                    <div class="mission-icon-wrapper mission-icon-sdg me-3">
                                        <div class="sdg-badge">
                                            <span class="sdg-number">12</span>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-3">Mendukung SDG 12</h5>
                                        <p class="text-muted mb-2">Mendukung <strong>SDG 12: Responsible Consumption and Production</strong> melalui penerapan prinsip ekonomi sirkular yang berkelanjutan.</p>
                                        <div class="sdg-info">
                                            <small class="text-success fw-semibold">
                                                <i class="bi bi-check-circle-fill me-1"></i>
                                                Sustainable Development Goals
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>            <!-- Tim Kami Section -->
            <section class="section-padding" id="tim">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-center mb-5">
                            <h2 class="section-title">🤝 Kenali Tim Kami</h2>
                            <p class="lead text-muted">Tim mahasiswa/i Informatika yang peduli terhadap isu lingkungan</p>
                        </div>
                    </div>
                    
                    <div class="row g-4 mb-4">                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="team-card">
                                <div class="team-avatar">
                                    <img src="{{ asset('assets/images/member/arya.JPG') }}" alt="Arya Dayusma Mundi">
                                </div>
                                <h5 class="fw-bold mb-2">Arya Dayusma Mundi</h5>
                                <p class="text-success fw-semibold mb-3">Lead Developer</p>
                                <p class="text-muted small">Pengembang fitur Autentikasi, Feedback, dan Event Campaign dengan fokus pada pengalaman pengguna yang optimal.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="team-card">
                                <div class="team-avatar">
                                    <img src="{{ asset('assets/images/member/ryggo.jpg') }}" alt="Ryggo Maulana Putra">
                                </div>
                                <h5 class="fw-bold mb-2">Ryggo Maulana Putra</h5>
                                <p class="text-success fw-semibold mb-3">Frontend Developer</p>
                                <p class="text-muted small">Pengembang Profil, Store, dan halaman About Us dengan desain yang user-friendly dan responsif.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="team-card">
                                <div class="team-avatar">
                                    <img src="{{ asset('assets/images/member/najma.png') }}" alt="Najma Qurrotul Aeni">
                                </div>
                                <h5 class="fw-bold mb-2">Najma Qurrotul Aeni</h5>
                                <p class="text-success fw-semibold mb-3">Content Developer</p>
                                <p class="text-muted small">Pengembang EcoNews dan EcoGive yang berfokus pada edukasi dan engagement masyarakat.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="team-card">
                                <div class="team-avatar">
                                    <img src="{{ asset('assets/images/member/fahmi.jpg') }}" alt="Fahmi Agus Sulistio">
                                </div>
                                <h5 class="fw-bold mb-2">Fahmi Agus Sulistio</h5>
                                <p class="text-success fw-semibold mb-3">System Developer</p>
                                <p class="text-muted small">Pengembang EcoCycle Home (Client) dan Sistem Poin yang memastikan integrasi sempurna antar fitur.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="team-card">
                                <div class="team-avatar">
                                    <img src="{{ asset('assets/images/member/farhan.jpg') }}" alt="Mochamad Farhan B.">
                                </div>
                                <h5 class="fw-bold mb-2">Mochamad Farhan B.</h5>
                                <p class="text-success fw-semibold mb-3">Backend Developer</p>
                                <p class="text-muted small">Pengembang EcoCycle Home (Vendor), Forum Diskusi, dan Nearby EcoHub dengan teknologi terdepan.</p>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="team-card">
                                <div class="team-avatar" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
                                    <i class="bi bi-people-fill" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Metodologi Agile</h5>
                                <p class="text-warning fw-semibold mb-3">Scrum Framework</p>
                                <p class="text-muted small">Kami bekerja dengan semangat kolaboratif menggunakan metodologi Agile Scrum untuk pembangunan yang adaptif dan berkelanjutan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- FAQ Section -->
            <section class="section-padding section-bg" id="faq">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-center mb-5">
                            <h2 class="section-title">❓ Pertanyaan yang Sering Diajukan</h2>
                            <p class="lead text-muted">Frequently Asked Questions (FAQ)</p>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-8 col-12 mx-auto">                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item faq-card">
                                    <h2 class="accordion-header faq-header" id="heading1">
                                        <button class="accordion-button text-decoration-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                            <i class="bi bi-question-circle-fill text-success me-3"></i>
                                            Apakah ReWasteX berbayar?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Tidak. Platform ini dapat digunakan secara gratis oleh masyarakat Kota Bandung. Kami berkomitmen menyediakan akses tanpa biaya untuk mendukung program pengelolaan sampah yang berkelanjutan.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item faq-card">
                                    <h2 class="accordion-header faq-header" id="heading2">
                                        <button class="accordion-button collapsed text-decoration-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                            <i class="bi bi-award-fill text-warning me-3"></i>
                                            Bagaimana cara mendapatkan poin?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Poin diperoleh saat Anda mengajukan permintaan daur ulang melalui fitur EcoCycle Home dan berhasil diproses oleh mitra/vendor. Semakin banyak sampah yang Anda daur ulang, semakin banyak poin yang akan Anda dapatkan.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item faq-card">
                                    <h2 class="accordion-header faq-header" id="heading3">
                                        <button class="accordion-button collapsed text-decoration-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                            <i class="bi bi-gift-fill text-primary me-3"></i>
                                            Apakah saya bisa menukarkan poin dengan barang?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Ya, Anda dapat menukarkan poin dengan hadiah menarik melalui halaman Store, atau berdonasi lewat fitur EcoGive. Tersedia berbagai pilihan reward yang dapat disesuaikan dengan poin yang Anda miliki.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item faq-card">
                                    <h2 class="accordion-header faq-header" id="heading4">
                                        <button class="accordion-button collapsed text-decoration-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                            <i class="bi bi-phone-fill text-info me-3"></i>
                                            Apakah ReWasteX tersedia dalam bentuk aplikasi mobile?
                                        </button>
                                    </h2>
                                    <div id="faq4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Saat ini, ReWasteX tersedia dalam versi website yang responsive dan dapat diakses melalui browser mobile. Pengembangan versi aplikasi mobile native menjadi target di tahap selanjutnya.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item faq-card">
                                    <h2 class="accordion-header faq-header" id="heading5">
                                        <button class="accordion-button collapsed text-decoration-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                                            <i class="bi bi-shield-check-fill text-success me-3"></i>
                                            Apakah data saya aman?
                                        </button>
                                    </h2>
                                    <div id="faq5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p>Ya. Keamanan data menjadi prioritas kami. Sistem autentikasi dan pengelolaan data dilakukan menggunakan Laravel dengan pengamanan standar industri, termasuk enkripsi data dan protokol keamanan terbaru.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>            <!-- Hubungi Kami Section -->
            <section class="section-padding hero-gradient" id="kontak">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-12 text-center mb-5">
                            <h2 class="text-white mb-3">📞 Hubungi Kami</h2>
                            <p class="lead text-white-50">Tim ReWasteX siap membantu Anda membangun masa depan yang lebih berkelanjutan</p>
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        <!-- Informasi Kontak -->
                        <div class="col-lg-4 col-12">
                            <div class="contact-info-card">
                                <div class="text-center mb-4">
                                    <div class="team-avatar mx-auto mb-3" style="width: 100px; height: 100px;">
                                        <i class="bi bi-headset" style="font-size: 2.5rem;"></i>
                                    </div>
                                    <h4 class="fw-bold text-success">Tim Support</h4>
                                    <p class="text-muted">Dukungan 24/7 untuk semua kebutuhan Anda</p>
                                </div>

                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Alamat Kantor</h6>
                                        <p class="text-muted mb-0 small">Fakultas Teknik Informatika<br>Universitas Telkom, Bandung</p>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Email Support</h6>
                                        <p class="text-muted mb-0 small">
                                            <a href="mailto:support@rewastex.com" class="text-decoration-none">support@rewastex.com</a>
                                        </p>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-phone-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Telepon</h6>
                                        <p class="text-muted mb-0 small">
                                            <a href="tel:+628001234567" class="text-decoration-none">+62 800 1234 567</a>
                                        </p>
                                    </div>
                                </div>

                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="bi bi-clock-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1">Jam Operasional</h6>
                                        <p class="text-muted mb-0 small">Senin - Jumat: 08:00 - 17:00 WIB<br>Sabtu: 08:00 - 12:00 WIB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Kontak -->
                        <div class="col-lg-8 col-12">
                            <div class="contact-info-card">
                                <h4 class="fw-bold text-success mb-4">💬 Kirim Pesan</h4>
                                <p class="text-muted mb-4">Punya pertanyaan tentang ReWasteX? Atau ingin memberikan saran? Kirim pesan kepada kami!</p>
                                
                                <form class="row g-3">
                                    <div class="col-md-6">
                                        <label for="firstName" class="form-label fw-semibold">Nama Depan</label>
                                        <input type="text" class="form-control form-control-lg" id="firstName" placeholder="Nama depan Anda" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label fw-semibold">Nama Belakang</label>
                                        <input type="text" class="form-control form-control-lg" id="lastName" placeholder="Nama belakang Anda" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="form-label fw-semibold">Email</label>
                                        <input type="email" class="form-control form-control-lg" id="email" placeholder="email@example.com" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="form-label fw-semibold">Subjek</label>
                                        <select class="form-select form-select-lg" id="subject" required>
                                            <option value="">Pilih kategori pesan</option>
                                            <option value="dukungan">Dukungan Teknis</option>
                                            <option value="saran">Saran & Kritik</option>
                                            <option value="kerjasama">Kerjasama</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label fw-semibold">Pesan</label>
                                        <textarea class="form-control" id="message" rows="6" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success btn-lg px-5 py-3">
                                            <i class="bi bi-send-fill me-2"></i>Kirim Pesan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media & CTA -->
                    <div class="row mt-5">
                        <div class="col-lg-12 text-center">
                            <div class="bg-white bg-opacity-10 rounded-4 p-4">
                                <h5 class="text-white fw-bold mb-3">🌍 Ikuti Perkembangan ReWasteX</h5>
                                <p class="text-white-50 mb-4">Bergabunglah dengan komunitas ReWasteX untuk update terbaru tentang program keberlanjutan</p>
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <a href="/register" class="btn btn-warning btn-lg px-4 py-3 rounded-pill">
                                        <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
                                    </a>
                                    <a href="/nearestecohub" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill">
                                        <i class="bi bi-geo-alt-fill me-2"></i>Temukan EcoHub
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@endsection