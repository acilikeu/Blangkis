<?php
$hlm = "Home";
if (uri_string() != "") {
  $hlm = ucwords(uri_string());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>- BLANGKIS - <?php echo $hlm ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url() ?>NiceAdmin/assets/img/favicon.png" rel="icon">
  <link href="<?= base_url() ?>NiceAdmin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAdmin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url() ?>NiceAdmin/assets/css/style.css" rel="stylesheet">

  <!-- Custom Brown Theme -->
  <style>
    :root {
      --bs-primary: #8B4513;
      --bs-secondary: #D2B48C;
      --bs-light: #f9f6f2;
      --bs-dark: #3E2F1C;
    }

    /* Root styling untuk layout utama */
    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      background-color: #FFF8F2;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
    }

    /* Warna navbar */
    .navbar,
    .header,
    .header-nav {
      background-color: var(--bs-primary) !important;
    }

    .navbar a,
    .header-nav a,
    .nav-link {
      color: #fff !important;
    }

    .navbar a:hover,
    .header-nav a:hover {
      color: var(--bs-secondary) !important;
    }

    .btn-outline-light {
      border-color: #fff;
      color: #fff;
    }

    .btn-outline-light:hover {
      background-color: var(--bs-secondary);
      color: #000;
    }

    main.main {
      flex: 1;
      /* konten ambil ruang tengah */
      padding: 30px 15px 60px 15px;
    }

    footer.footer {
      background-color: #f3f0e9;
      color: #5e4a3d;
      text-align: center;
      padding: 20px 0;
      font-size: 14px;
      margin-top: auto;
      border-top: 1px solid #ddd;
    }

    /* Spacing agar content tidak terlalu menempel navbar */
    .keranjang-card {
      margin-top: 20px;
      padding: 30px;
      background-color: #fff;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    /* Optional: agar footer tidak mepet layar saat isi pendek */
    .wrapper {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    /* Hilangkan sisa ruang sidebar */
    #main.main,
    main.main {
      margin-left: 0 !important;
      padding-left: 1rem;
      padding-right: 1rem;
    }

    @media (min-width: 1200px) {

      #main.main,
      main.main {
        padding-left: 2rem;
        padding-right: 2rem;
      }
    }

    body {
      overflow-x: hidden;
    }

    .container,
    .container-fluid {
      max-width: 100%;
    }
  </style>

</head>

<body>

  <!-- Header/Navbar -->
  <header class="header d-flex align-items-center fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <a href="<?= base_url() ?>" class="logo d-flex align-items-center"
        style="white-space: nowrap; color: #fff; font-family: 'Poppins', sans-serif; font-weight: 600; font-size: 20px;">
        <img src="<?= base_url('NiceAdmin/assets/img/BLANGKONPUTIH.png') ?>" alt="Logo"
          style="height: 32px; margin-right: 10px;">
        <span style="color:#fff;">BLANGKON-PAKIS</span>
      </a>

      <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center mb-0">

          <li class="nav-item px-2">
            <a class="nav-link" href="<?= base_url('/') ?>">Home</a>
          </li>
          <?php if (session()->get('role') == 'admin'): ?>
            <!-- Menu Admin -->
            <li class="nav-item px-2"><a class="nav-link" href="<?= base_url('admin/order') ?>">Konsumen</a></li>
            <li class="nav-item px-2"><a class="nav-link" href="<?= base_url('laporan') ?>">Laporan</a></li>
          <?php else: ?>
            <!-- Menu User -->
            <li class="nav-item px-2"><a class="nav-link" href="<?= base_url('keranjang') ?>">Keranjang</a></li>
          <?php endif; ?>
          <li class="nav-item px-2">
            <a class="nav-link" href="<?= base_url('produk') ?>">Produk</a>
          </li>

          <li class="nav-item px-2">
            <a class="nav-link" href="<?= base_url('profile') ?>">Transaksi</a>
          </li>

          <?php if (session()->get('role') != 'admin'): ?>
            <li class="nav-item px-2">
              <form class="d-flex" method="get" action="<?= base_url('search') ?>">
                <input class="form-control me-2" type="search" name="q" placeholder="Cari..." />
                <button class="btn btn-outline-light" type="submit">Cari</button>
              </form>
            </li>
          <?php endif; ?>

          <!-- Login / Logout Section -->
          <?php if (!session()->get('isLoggedIn') && !session()->get('logged_in')): ?>
            <li class="nav-item px-2">
              <a class="btn btn-outline-light" href="<?= base_url('login') ?>">Login</a>
            </li>
          <?php else: ?>
            <li class="nav-item px-2 d-flex align-items-center">
              <?php if (session('foto')): ?>
                <img src="<?= session('foto') ?>" width="35" height="35" class="rounded-circle me-2" style="object-fit: cover;">
              <?php endif; ?>
              <span style="color: white; margin-right: 10px;">
                <?= session('nama') ?? session('username') ?>
              </span>
              <a class="btn btn-outline-light" href="<?= base_url('logout') ?>">Logout</a>
            </li>
          <?php endif; ?>

        </ul>
      </nav>


    </div>
  </header>
  <!-- End Header -->

  <?php
  $currentPage = uri_string();
  $isHome = ($currentPage == '' || $currentPage == '/' || $currentPage == 'home');
  ?>

  <?php if (!$isHome): ?>
    <main id="main" class="main pt-5" style="margin-top: 70px;">
      <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <?= $this->renderSection('content') ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  <?php else: ?>
    <main id="main" class="main pt-5" style="margin-top: 70px;">
      <?= $this->renderSection('content') ?>
    </main>
  <?php endif; ?>

  <!-- Footer -->
  <footer class="footer bg-light py-3 text-center">
    <div class="container">
      <span class="text-muted">&copy; <?= date('Y') ?> BLANGKIS. All rights reserved.</span>
    </div>
  </footer>

  <!-- Back to Top -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- jQuery & Select2 -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Vendor JS Files -->
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/quill/quill.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/tinymce/tinymce.min.js"></script>

  <!-- Main JS -->
  <script src="<?= base_url() ?>NiceAdmin/assets/js/main.js"></script>

  <?= $this->renderSection('script') ?>
</body>

</html>