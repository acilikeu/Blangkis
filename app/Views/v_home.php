<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
  :root {
    --primary-brown: #8B4513;
    --light-brown: #D2B48C;
    --cream: #FFF8F2;
    --card-bg: #FFFFFF;
    --text-dark: #2C1810;
    --text-gray: #6B5B73;
    --accent-gold: #DAA520;
    --gradient-primary: linear-gradient(135deg, #8B4513, #A0522D);
    --gradient-secondary: linear-gradient(135deg, #DAA520, #FFD700);
    --shadow-light: rgba(139, 69, 19, 0.1);
    --shadow-medium: rgba(139, 69, 19, 0.2);
    --shadow-heavy: rgba(139, 69, 19, 0.3);
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Inter', 'Segoe UI', sans-serif;
    line-height: 1.6;
    color: var(--text-dark);
    overflow-x: hidden;
  }

  /* Hero Section */
  .hero-section {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--cream) 0%, #F5F0E8 50%, #EDE7D9 100%);
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
  }

  .hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(139, 69, 19, 0.08) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
  }

  .hero-section::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(218, 165, 32, 0.05) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 8s ease-in-out infinite reverse;
  }

  @keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(10deg); }
  }

  .hero-content {
    position: relative;
    z-index: 2;
  }

  .hero-title {
    font-size: clamp(2.5rem, 6vw, 4.5rem);
    font-weight: 900;
    color: var(--text-dark);
    margin-bottom: 20px;
    line-height: 1.1;
  }

  .hero-title .highlight {
    background: var(--gradient-secondary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .hero-subtitle {
    font-size: clamp(1.1rem, 2.5vw, 1.4rem);
    color: var(--text-gray);
    margin-bottom: 30px;
    max-width: 600px;
  }

  .hero-buttons {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 50px;
  }

  .btn-primary {
    background: var(--gradient-primary);
    color: white;
    padding: 15px 35px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px var(--shadow-light);
    position: relative;
    overflow: hidden;
  }

  .btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
  }

  .btn-primary:hover::before {
    left: 100%;
  }

  .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px var(--shadow-medium);
    color: white;
    text-decoration: none;
  }

  .btn-secondary {
    background: transparent;
    color: var(--primary-brown);
    padding: 15px 35px;
    border: 2px solid var(--primary-brown);
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
  }

  .btn-secondary:hover {
    background: var(--primary-brown);
    color: white;
    transform: translateY(-3px);
    text-decoration: none;
    box-shadow: 0 8px 25px var(--shadow-light);
  }

  .hero-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
    gap: 30px;
    max-width: 500px;
  }

  .stat-item {
    text-align: center;
  }

  .stat-number {
    font-size: 2.5rem;
    font-weight: 900;
    color: var(--primary-brown);
    display: block;
  }

  .stat-label {
    font-size: 14px;
    color: var(--text-gray);
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .hero-image {
    position: relative;
    z-index: 2;
  }

  .hero-image img {
    width: 100%;
    height: auto;
    border-radius: 20px;
    box-shadow: 0 20px 60px var(--shadow-medium);
    transition: transform 0.3s ease;
  }

  .hero-image:hover img {
    transform: scale(1.05);
  }

  /* Products Section */
  .products-section {
    padding: 100px 0;
    background: white;
    position: relative;
    overflow: hidden;
  }

  .products-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(139, 69, 19, 0.05) 0%, transparent 70%);
    border-radius: 50%;
    z-index: 0;
  }

  .section-header {
    text-align: center;
    margin-bottom: 60px;
    position: relative;
    z-index: 1;
  }

  .section-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 15px;
    position: relative;
    display: inline-block;
  }

  .section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 4px;
    background: var(--gradient-secondary);
    border-radius: 2px;
  }

  .section-subtitle {
    font-size: 18px;
    color: var(--text-gray);
    max-width: 600px;
    margin: 0 auto;
  }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    padding: 0 15px;
    position: relative;
    z-index: 1;
  }

  .product-card {
    background: var(--card-bg);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px var(--shadow-light);
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .product-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px var(--shadow-medium);
  }

  .product-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
  }

  .product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
  }

  .product-card:hover .product-image {
    transform: scale(1.1);
  }

  .product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: var(--gradient-secondary);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .product-content {
    padding: 25px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .product-name {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 10px;
    line-height: 1.3;
  }

  .product-description {
    font-size: 14px;
    color: var(--text-gray);
    margin-bottom: 20px;
    flex-grow: 1;
  }

  .product-price {
    font-size: 24px;
    font-weight: 800;
    color: var(--primary-brown);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .currency-symbol {
    font-size: 16px;
    opacity: 0.8;
  }

  .btn-add-cart {
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .btn-add-cart::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
  }

  .btn-add-cart:hover::before {
    left: 100%;
  }

  .btn-add-cart:hover {
    background: linear-gradient(135deg, #A0522D, var(--accent-gold));
    transform: translateY(-2px);
    box-shadow: 0 8px 25px var(--shadow-heavy);
  }

  .btn-add-cart:active {
    transform: translateY(0);
  }

  /* Features Section */
  .features-section {
    padding: 100px 0;
    background: linear-gradient(135deg, var(--cream) 0%, #F5F0E8 100%);
    position: relative;
  }

  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 40px;
    margin-top: 60px;
  }

  .feature-card {
    background: var(--card-bg);
    padding: 40px 30px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 10px 30px var(--shadow-light);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(139, 69, 19, 0.02), transparent);
    transition: left 0.5s;
  }

  .feature-card:hover::before {
    left: 100%;
  }

  .feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px var(--shadow-medium);
  }

  .feature-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    font-size: 2rem;
    color: white;
    box-shadow: 0 8px 25px var(--shadow-light);
  }

  .feature-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 15px;
  }

  .feature-description {
    color: var(--text-gray);
    line-height: 1.6;
  }

  /* Alert Styles */
  .alert {
    border-radius: 15px;
    border: none;
    padding: 15px 20px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }

  .alert-success {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .hero-section {
      min-height: 80vh;
      padding: 40px 0;
    }
    
    .hero-buttons {
      justify-content: center;
    }
    
    .btn-primary, .btn-secondary {
      padding: 12px 25px;
      font-size: 14px;
    }
    
    .hero-stats {
      grid-template-columns: repeat(2, 1fr);
    }
    
    .products-section, .features-section {
      padding: 60px 0;
    }
    
    .products-grid, .features-grid {
      grid-template-columns: 1fr;
      gap: 30px;
    }
    
    .product-image-container {
      height: 200px;
    }
    
    .product-content {
      padding: 20px;
    }
    
    .feature-card {
      padding: 30px 20px;
    }
  }

  @media (max-width: 480px) {
    .hero-buttons {
      flex-direction: column;
      align-items: center;
    }
    
    .btn-primary, .btn-secondary {
      width: 100%;
      max-width: 280px;
      justify-content: center;
    }
    
    .hero-stats {
      grid-template-columns: 1fr;
    }
    
    .products-grid {
      padding: 0 10px;
    }
    
    .product-content {
      padding: 15px;
    }
    
    .btn-add-cart {
      padding: 10px 20px;
      font-size: 14px;
    }
  }
</style>

<?php if (session()->getFlashData('success')): ?>
  <div class="container">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="fas fa-check-circle me-2"></i>
      <?= session()->getFlashData('success') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif ?>

<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="hero-content">
          <h1 class="hero-title">
            Temukan Produk <span class="highlight">Terbaik</span> untuk Anda
          </h1>
          <p class="hero-subtitle">
            Koleksi lengkap produk berkualitas premium dengan harga terjangkau. 
            Berbelanja mudah, aman, dan terpercaya hanya di sini.
          </p>
          <div class="hero-buttons">
            <a href="#products" class="btn-primary">
              <i class="fas fa-shopping-bag"></i>
              Lihat Produk
            </a>
            <a href="#features" class="btn-secondary">
              <i class="fas fa-info-circle"></i>
              Pelajari Lebih Lanjut
            </a>
          </div>
          <div class="hero-stats">
            <div class="stat-item">
              <span class="stat-number">1000+</span>
              <span class="stat-label">Produk</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">5000+</span>
              <span class="stat-label">Pelanggan</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">4.9</span>
              <span class="stat-label">Rating</span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="hero-image">
          <img src="<?= base_url('NiceAdmin/assets/img/blangkon-estetik.jpeg') ?>" alt="Hero Image" 
               style="width: 100%; height: 400px; object-fit: cover; background: linear-gradient(45deg, #f8f9fa, #e9ecef);">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Products Section -->
<section id="products" class="products-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Produk Terbaru</h2>
      <p class="section-subtitle">
        Temukan koleksi produk terbaik kami dengan kualitas premium dan harga terjangkau
      </p>
    </div>

    <div class="products-grid">
      <?php foreach ($product as $item): ?>
        <div class="product-card">
          <?= form_open('keranjang', ['class' => 'h-100 d-flex flex-column']) ?>
            <?= form_hidden('id', $item['id']) ?>
            <?= form_hidden('nama', $item['nama']) ?>
            <?= form_hidden('harga', $item['harga']) ?>
            <?= form_hidden('foto', $item['foto']) ?>
            
            <div class="product-image-container">
              <img src="<?= base_url("img/" . $item['foto']) ?>" 
                   alt="<?= esc($item['nama']) ?>" 
                   class="product-image"
                   loading="lazy">
              <div class="product-badge">Terbaru</div>
            </div>
            
            <div class="product-content">
              <h3 class="product-name"><?= esc($item['nama']) ?></h3>
              <p class="product-description">
                Produk berkualitas tinggi dengan bahan terbaik dan desain yang menarik
              </p>
              <div class="product-price">
                <span class="currency-symbol">Rp</span>
                <?= number_format($item['harga'], 0, ',', '.') ?>
              </div>
              <button type="submit" class="btn-add-cart">
                <i class="fas fa-cart-plus me-2"></i>
                Tambah ke Keranjang
              </button>
            </div>
          <?= form_close() ?>
        </div>
      <?php endforeach ?>
    </div>
  </div>
</section>

<!-- Features Section -->
<section id="features" class="features-section">
  <div class="container">
    <div class="section-header">
      <h2 class="section-title">Mengapa Memilih Kami?</h2>
      <p class="section-subtitle">
        Kami berkomitmen memberikan pengalaman berbelanja terbaik dengan layanan berkualitas tinggi
      </p>
    </div>
    
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-shipping-fast"></i>
        </div>
        <h3 class="feature-title">Pengiriman Cepat</h3>
        <p class="feature-description">
          Pengiriman ke seluruh Indonesia dengan estimasi 1-3 hari kerja. 
          Gratis ongkir untuk pembelian minimal Rp 100.000
        </p>
      </div>
      
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-award"></i>
        </div>
        <h3 class="feature-title">Kualitas Terjamin</h3>
        <p class="feature-description">
          Semua produk telah melalui quality control ketat dan bergaransi resmi. 
          100% original dan berkualitas premium
        </p>
      </div>
      
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-headset"></i>
        </div>
        <h3 class="feature-title">Customer Service 24/7</h3>
        <p class="feature-description">
          Tim customer service siap membantu Anda 24 jam sehari, 7 hari seminggu. 
          Respon cepat dan solusi terbaik
        </p>
      </div>
      
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-shield-alt"></i>
        </div>
        <h3 class="feature-title">Belanja Aman</h3>
        <p class="feature-description">
          Transaksi dilindungi dengan enkripsi SSL dan berbagai metode pembayaran aman. 
          Data pribadi terjaga dengan baik
        </p>
      </div>
      
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-undo"></i>
        </div>
        <h3 class="feature-title">Mudah Return</h3>
        <p class="feature-description">
          Kebijakan return 7 hari tanpa ribet. Jika tidak puas, 
          barang bisa dikembalikan dengan mudah
        </p>
      </div>
      
      <div class="feature-card">
        <div class="feature-icon">
          <i class="fas fa-tags"></i>
        </div>
        <h3 class="feature-title">Harga Terbaik</h3>
        <p class="feature-description">
          Dapatkan harga terbaik dengan berbagai promo menarik. 
          Cashback, diskon, dan program loyalitas pelanggan
        </p>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>