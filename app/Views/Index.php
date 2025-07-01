<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
  :root {
    --coklat-tua: #8B4513;
    --coklat-muda: #D2B48C;
    --coklat-bg: #FFF8F2;
    --coklat-card: #FFF3E6;
    --text-dark: #3E2F1C;
  }

  body {
    background-color: var(--coklat-bg);
    font-family: 'Poppins', sans-serif;
  }

  .produk-wrapper {
    padding: 30px 15px;
  }

  .produk-title {
    text-align: center;
    font-size: 32px;
    font-weight: bold;
    color: var(--text-dark);
    margin-bottom: 30px;
  }

  .card-produk {
    background-color: var(--coklat-card);
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 20px rgba(139, 69, 19, 0.1);
    transition: transform 0.2s ease;
    height: 100%;
  }

  .card-produk:hover {
    transform: translateY(-5px);
  }

  .card-produk img {
    max-width: 100%;
    height: auto;
    margin-bottom: 15px;
  }

  .card-title {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 10px;
  }

  .card-price {
    font-size: 16px;
    color: var(--text-dark);
    margin-bottom: 15px;
  }

  .btn-beli {
    background-color: var(--coklat-tua);
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    transition: 0.3s;
  }

  .btn-beli:hover {
    background-color: var(--coklat-muda);
    color: #000;
  }
</style>

<?php if (session()->getFlashData('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashData('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<h1>Selamat datang Admin <?= session('username') ?></h1>
<p>Ini adalah halaman khusus admin!</p>

<div class="produk-wrapper">
  <div class="produk-title">Produk Terbaru</div>
  <div class="row g-4">
    <?php foreach ($product as $item): ?>
      <div class="col-lg-6 col-md-6 col-sm-12 d-flex">
        <?= form_open('keranjang', ['class' => 'w-100']) ?>
          <?= form_hidden('id', $item['id']) ?>
          <?= form_hidden('nama', $item['nama']) ?>
          <?= form_hidden('harga', $item['harga']) ?>
          <?= form_hidden('foto', $item['foto']) ?>

          <div class="card-produk text-center w-100">
            <img src="<?= base_url("img/" . $item['foto']) ?>" alt="<?= esc($item['nama']) ?>">
            <div class="card-title"><?= esc($item['nama']) ?></div>
            <div class="card-price"><?= number_to_currency($item['harga'], 'IDR') ?></div>
            <button type="submit" class="btn btn-beli">Beli</button>
          </div>

        <?= form_close() ?>
      </div>
    <?php endforeach ?>
  </div>
</div>

<?= $this->endSection() ?>
