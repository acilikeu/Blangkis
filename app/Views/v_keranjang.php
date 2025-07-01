<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<style>
  :root {
    --coklat-tua: #8B4513;
    --coklat-muda: #D2B48C;
    --coklat-bg: #FFF8F2;
    --coklat-kartu: #FFF3E6;
    --coklat-aksen: #4B2E1E;
  }

  body {
    background-color: var(--coklat-bg);
    font-family: 'Poppins', sans-serif;
  }

  .keranjang-card {
    background-color: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    margin-bottom: 30px;
  }

  table thead {
    background-color: var(--coklat-tua);
    color: white;
  }

  table tbody {
    background-color: var(--coklat-kartu);
  }

  .table td, .table th {
    vertical-align: middle;
    text-align: center;
  }

  .form-control {
    border-radius: 10px;
    text-align: center;
    height: 45px;
  }

  .total-box {
    background-color: var(--coklat-muda);
    padding: 15px 20px;
    border-radius: 10px;
    font-weight: 500;
    font-size: 16px;
    color: var(--coklat-aksen);
    margin-bottom: 20px;
  }

  .btn-aksi {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: flex-end;
  }

  .btn-coklat {
    background-color: var(--coklat-tua);
    color: white;
    border: none;
  }

  .btn-coklat:hover {
    background-color: var(--coklat-muda);
    color: black;
  }

  .btn-oren {
    background-color: #c77c15;
    color: white;
    border: none;
  }

  .btn-oren:hover {
    background-color: #ffc06c;
    color: black;
  }

  .btn-hijau {
    background-color: #2f8432;
    color: white;
    border: none;
  }

  .btn-hijau:hover {
    background-color: #7dd67d;
    color: black;
  }

  .btn-danger {
    background-color: #a94442;
    border: none;
  }

  .btn-danger:hover {
    background-color: #e55f5f;
    color: white;
  }

  .btn i {
    vertical-align: middle;
  }
</style>

<?php if (session()->getFlashData('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <?= session()->getFlashData('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif ?>

<?= form_open('keranjang/edit') ?>

<div class="keranjang-card">

  <div class="table-responsive mb-3">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Foto</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Subtotal</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php if (!empty($items)): ?>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?= esc($item['name']) ?></td>
              <td><img src="<?= base_url("img/" . $item['options']['foto']) ?>" width="80px" class="rounded"></td>
              <td><?= number_to_currency($item['price'], 'IDR') ?></td>
              <td>
                <input type="number" min="1" name="qty<?= $i++ ?>" class="form-control" value="<?= $item['qty'] ?>">
              </td>
              <td><?= number_to_currency($item['subtotal'], 'IDR') ?></td>
              <td>
                <a href="<?= base_url('keranjang/delete/' . $item['rowid']) ?>" class="btn btn-danger">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php endforeach ?>
        <?php endif ?>
      </tbody>
    </table>
  </div>

  <div class="total-box">
    Total Belanja: <strong><?= number_to_currency($total, 'IDR') ?></strong>
  </div>

  <div class="btn-aksi">
    <button type="submit" class="btn btn-coklat">Perbarui Keranjang</button>
    <a href="<?= base_url('keranjang/clear') ?>" class="btn btn-oren">Kosongkan Keranjang</a>
    <?php if (!empty($items)): ?>
      <a href="<?= base_url('checkout') ?>" class="btn btn-hijau">Selesai Belanja</a>
    <?php endif ?>
  </div>

</div>

<?= form_close() ?>
<?= $this->endSection() ?>
