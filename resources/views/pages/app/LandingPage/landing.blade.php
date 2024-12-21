<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer 77 - Bimbel Online Komputer</title>
    <style>
        * /* Reset CSS */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Header Styles */
.header {
    background: linear-gradient(135deg, #0033cc, #3366ff, #6699ff); /* Gradasi biru laut */
    padding: 20px;
    color: white;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Efek bayangan halus */
}


/* Navigation Styles */
.nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px; /* Lebar maksimal untuk navigasi */
    margin: 0 auto; /* Tengah-kan kontainer nav */
}

/* Logo Style */
.logo {
    font-size: 24px;
    font-weight: bold;
}

/* Navigation Links */
.nav-links {
    display: flex;
    gap: 20px; /* Jarak antar tautan */
}

.nav-links a {
    color: white;
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 20px;
    transition: background 0.3s; /* Efek transisi untuk hover */
}

/* .nav-links a:hover {
    background: rgba(255, 255, 255, 0.2); /* Efek hover dengan latar belakang putih transparan */


/* Navigation Bar Background */


/* Navigation Links in Navbar */
nav a {
    color: white;
    text-decoration: none;
    padding: 10px 15px;
    transition: color 0.3s ease-in-out; /* Efek transisi untuk warna */
}

nav a:hover {
    color: #ffcc00; /* Warna hover kuning lembut */
}


        /* Hero Section */
    .hero {
    background: linear-gradient(135deg, #0033cc, #3366ff, #6699ff); /* Gradasi biru ke biru langit */
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    padding: 0 20px;
    margin-top: 60px;
}

        .hero-content {
            max-width: 800px;
        }

        .hero-content h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeIn 1s ease-out;
        }

        .hero-content p {
            font-size: 20px;
            margin-bottom: 30px;
            animation: fadeIn 1.5s ease-out;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-size: 18px;
            transition: transform 0.3s, background 0.3s;
            animation: fadeIn 2s ease-out;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            background: #45a049;
        }

        /* Features Section */
        .features {
            padding: 80px 20px;
            background: #f9f9f9;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-card h3 {
            color: #1e3c72;
            margin: 20px 0;
        }

        /* Testimonials Section */
        .testimonials {
            padding: 80px 20px;
            background: white;
        }

        .testimonials-container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .testimonial-card {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 600px;
        }

        .contact {
    padding: 80px 20px;
    background: linear-gradient(135deg, #e6f7ff, #cceeff); /* Gradasi biru muda */
    color: #333;
    border-top: 4px solid #3366cc; /* Pembatas atas */
    border-bottom: 4px solid #3366cc; /* Pembatas bawah */
}

.contact-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.contact-container h2 {
    margin-bottom: 20px;
    font-size: 28px;
    color: #0033cc;
}

.contact-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.contact-item {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 10px;
    text-align: left;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.contact-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.contact-item i {
    font-size: 28px;
    color: #0033cc;
    flex-shrink: 0;
}

.contact-item p {
    margin: 0;
    font-size: 16px;
}

.contact-item a {
    color: #0033cc;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s;
}

.contact-item a:hover {
    color: #ff6600;
}


        .about {
    padding: 100px 20px;
    background: linear-gradient(135deg, #f5f7fa, #e8ecf3);
    position: relative;
    overflow: hidden;
}

.about-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
}

.about-content {
    animation: fadeIn 1s ease-out;
}

.about-content h2 {
    font-size: 36px;
    color: #1e3c72;
    margin-bottom: 25px;
    position: relative;
}

.about-content h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 80px;
    height: 4px;
    background: #4CAF50;
    border-radius: 2px;
}

.about-content p {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
    margin-bottom: 20px;
}

.about-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 40px;
}

.stat-item {
    text-align: center;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.stat-item:hover {
    transform: translateY(-5px);
}

.stat-number {
    font-size: 36px;
    font-weight: bold;
    color: #1e3c72;
    margin-bottom: 10px;
}

.stat-label {
    color: #666;
    font-size: 14px;
}

.about-image {
    position: relative;
    width: 100%;
    height: 0;
    padding-bottom: 75%; /* Membuat aspect ratio 4:3 */
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    background: #f0f0f0;
}

.about-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain; /* Mengubah dari cover ke contain agar gambar tidak terpotong */
    padding: 20px; /* Memberikan ruang di sekitar gambar */
}

@media (max-width: 768px) {
    .about-container {
        grid-template-columns: 1fr;
    }
    
    .about-image {
        padding-bottom: 60%; /* Sedikit lebih pendek di mobile */
    }
    
    .about-stats {
        grid-template-columns: 1fr;
    }
}

        /* Footer */
        .footer {
            background: #132344;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav {
                flex-direction: column;
                gap: 20px;
            }

            .hero-content h1 {
                font-size: 36px;
            }

            .hero-content p {
                font-size: 18px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <div class="logo">Computer 77</div>
            <div class="nav-links">
                <a href="#beranda">Beranda</a>
                <a href="#program">Program</a>
                <a href="#testimoni">Testimoni</a>
                <a href="#kontak">Kontak</a>
                <a href="#tentang-kami">Tentang Kami</a>
              
            </div>
        </nav>
    </header>

    <section class="hero" id="beranda">
        <div class="hero-content">
            <h1>Belajar Komputer Jadi Lebih Mudah</h1>
            <p>Tingkatkan kemampuan komputermu bersama pemateri berpengalaman melalui pembelajaran online yang interaktif</p>
            <a href="{{ route('login') }}" class="cta-button">Mulai Belajar Sekarang</a>
        </div>
    </section>

    <section class="features" id="program">
        <div class="features-grid">
            <div class="feature-card">
                <h3>Pembelajaran Online</h3>
                <p>Belajar dari mana saja dan kapan saja dengan materi yang dapat diakses 24/7</p>
            </div>
            <div class="feature-card">
                <h3>Pemateri Profesional</h3>
                <p>Dibimbing langsung oleh praktisi IT berpengalaman di bidangnya</p>
            </div>
            <div class="feature-card">
                <h3>Materi Terstruktur</h3>
                <p>Kurikulum dirancang sistematis dari dasar hingga mahir</p>
            </div>
        </div>
    </section>

    <section class="testimonials" id="testimoni">
        <div class="testimonials-container">
            <h2>Apa Kata Mereka?</h2>
            <div class="testimonial-card">
                <p>"Belajar di Computer 77 sangat menyenangkan. Materinya mudah dipahami dan mentornya sangat membantu."</p>
                <h4>Aqiel Mubarok</h4>
            </div>
        </div>
    </section>

    <section class="contact" id="kontak">
    <div class="contact-container">
        <h2>Hubungi Kami</h2>
        <div class="contact-details">
            <div class="contact-item">
                <i class="fas fa-building"></i>
                <p><strong>Nama Perusahaan:</strong><br>Computer 77</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <p><strong>Email:</strong><br><a href="mailto:info@computer77.com">info@computer77.com</a></p>
            </div>
            <div class="contact-item">
                <i class="fab fa-instagram"></i>
                <p><strong>Instagram:</strong><br><a href="https://instagram.com/computer77" target="_blank">@computer77</a></p>
            </div>
            <div class="contact-item">
                <i class="fab fa-whatsapp"></i>
                <p><strong>WhatsApp:</strong><br><a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a></p>
            </div>
            <div class="contact-item">
                <i class="fab fa-facebook"></i>
                <p><strong>Facebook:</strong><br><a href="https://facebook.com/computer77" target="_blank">Computer 77</a></p>
            </div>
            <div class="contact-item">
                <i class="fab fa-youtube"></i>
                <p><strong>YouTube:</strong><br><a href="https://youtube.com/@computer77" target="_blank">Channel Computer 77</a></p>
            </div>
        </div>
    </div>
</section>

    <section class="about" id="tentang-kami">
    <div class="about-container">
        <div class="about-content">
            <h2>Tentang Computer 77</h2>
            <p>Computer 77 adalah lembaga bimbingan belajar komputer terbaru yang didirikan pada tahun 2023 dengan visi mencerdaskan generasi digital Indonesia. Kami percaya bahwa setiap orang berhak mendapatkan pendidikan teknologi yang berkualitas dan terjangkau.</p>
            <p>Dengan menggabungkan metode pembelajaran modern dan pengalaman praktis, kami yakin dapat membantu ratusan siswa menguasai keterampilan komputer yang esensial untuk masa depan mereka.</p>
            <div class="about-stats">
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Siswa Bergabung</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Mentor Profesional</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4+</div>
                    <div class="stat-label">Program Kursus</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Menjamin Tingkat Kepuasan</div>
                </div>
            </div>
        </div>
        <div class="about-image">
            <img src="{{ asset('img/komputer 77.jpg') }}" alt="Tim Bimbel 77">
        </div>
    </div>
</section>

    <footer class="footer">
        <p>&copy; 2024 Computer 77 - Bimbel Online Komputer. All rights reserved.</p>
    </footer>
</body>
</html>