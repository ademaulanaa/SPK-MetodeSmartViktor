<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PARFUMOLOGI - Sistem Rekomendasi Parfum</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="stylee.css" />
</head>
<body>
    <nav class="navbar navbar-expand-lg" role="navigation" aria-label="Main navigation">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-spray-can" aria-hidden="true"></i> PARFUMOLOGI
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="smart.php">Smart System</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="fas fa-sign-in-alt" aria-hidden="true"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section" aria-label="Hero Section" style="background-image: url('assets/img/perfume_background.jpg');">
        <div class="container">
            <h1 class="hero-title">PARFUMOLOGI</h1>
            <h2 class="hero-subtitle">Sistem Rekomendasi Parfum Cerdas</h2>
            <p class="hero-description">
                Temukan parfum yang sempurna untuk Anda dengan teknologi rekomendasi berbasis kecerdasan buatan.
                Sistem kami menganalisis preferensi dan karakteristik untuk memberikan rekomendasi yang tepat.
            </p>
            <a href="login.php" class="cta-button" role="button">
                <i class="fas fa-magic" aria-hidden="true"></i> Mulai Rekomendasi
            </a>
        </div>
        <div class="scroll-indicator" aria-hidden="true">
            <i class="fas fa-chevron-down fa-2x"></i>
        </div>
    </section>

    <section class="features-section" id="fitur" aria-label="Fitur Unggulan">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="row gy-4">
                <div class="col-md-4 d-flex">
                    <article class="feature-card">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3 class="feature-title">Powered Recommendation</h3>
                        <p class="feature-description">
                            Sistem rekomendasi menggunakan algoritma smart untuk memberikan saran parfum yang akurat berdasarkan preferensi personal Anda.
                        </p>
                    </article>
                </div>
                <div class="col-md-4 d-flex">
                    <article class="feature-card">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="feature-title">Smart Search</h3>
                        <p class="feature-description">
                            Pencarian cerdas dengan filter berdasarkan kategori, aroma, brand, dan rating untuk menemukan parfum impian Anda dengan mudah.
                        </p>
                    </article>
                </div>
                <div class="col-md-4 d-flex">
                    <article class="feature-card">
                        <div class="feature-icon" aria-hidden="true">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="feature-title">Real-time Analytics</h3>
                        <p class="feature-description">
                            Dashboard analitik lengkap untuk memantau performa sistem rekomendasi dan tren preferensi pengguna secara real-time.
                        </p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section" id="tentang" aria-label="Tentang Parfumologi">
        <div class="container">
            <div class="about-content">
                <h2 class="section-title">Tentang Parfumologi</h2>
                <p class="about-text">
                    Parfumologi adalah sistem rekomendasi parfum berbasis web yang dikembangkan menggunakan teknologi
                    terdepan dalam bidang sistem pendukung keputusan. Dengan menggabungkan data preferensi pengguna,
                    karakteristik parfum, dan algoritma machine learning, kami menyediakan rekomendasi yang personal
                    dan akurat untuk membantu Anda menemukan parfum yang sempurna.
                </p>
                <p class="about-text">
                    Proyek ini merupakan bagian dari penelitian skripsi yang berfokus pada pengembangan sistem
                    pendukung keputusan dalam industri parfum, dengan tujuan meningkatkan pengalaman berbelanja
                    dan kepuasan konsumen melalui teknologi rekomendasi yang cerdas.
                </p>
            </div>
        </div>
    </section>

    <section class="stats-section" aria-label="Statistik Sistem">
        <div class="container">
            <div class="row g-4 justify-content-center text-center">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-number" aria-label="Jumlah database parfum">500+</div>
                        <div class="stat-label">Database Parfum</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-number" aria-label="Akurasi rekomendasi">95%</div>
                        <div class="stat-label">Akurasi Rekomendasi</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-number" aria-label="Sistem aktif 24 jam">24/7</div>
                        <div class="stat-label">Sistem Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer" role="contentinfo">
        <div class="container">
            <p>&copy; 2024 Parfumologi - Sistem Rekomendasi Parfum. Dikembangkan untuk Skripsi SPK.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>